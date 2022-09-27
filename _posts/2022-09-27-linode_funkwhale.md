---
tabtitle: "Funkwhale On Linode with Object Storage"
title: "Funkwhale on Linode with Object Storage"
topics: [technology]
pub: "2022-09-27"
short_desc: "Funkwhale is a cool project, building a federated music platform. I
wanted to explore Funkwhale's ability to store music and associated files in
object storage, and since I already use Linode for my VPS, leveraging their
object storage offering makes a lot of sense."
---

# Funkwhale on Linode with Object Storage

## Funkwhale Setup

[Funkwhale](https://funkwhale.audio/) is a decentralized music service,
connecting to the [fediverse](https://en.wikipedia.org/wiki/Fediverse) using the
ActivityPub protocol. It is a web-based application, allowing users to upload,
listen, and share music and podcasts. I think it's a cool project, and I can
self-host it, so I did. For a while, Funkwhale offered an all-in-one Docker
container, but they shifted focus to a multi-container approach. I had delayed
my transition from all-in-one to multi-container, but finally this past weekend
I found myself with time and motivation to get it done. The installation of
Funkwhale using Docker is very straight forward. The community has developed a
series of templates that can be fetched, modified, and used to get started very
quickly and easily. Those instructions are
[here](https://docs.funkwhale.audio/installation/docker.html#multi-container-installation).
The only significant modification I made was using `/opt/funkwhale` as my
default data and media root. I keep all my Docker configuration in directories
in my home directory as well. Much of these changes can be established in the
`.env` file discussed in the installation instructions, but I also scrubbed the
template files created and used during installation to make sure the directories
were as I wanted them. I also proxy Funkwhale and many other services behind
nginx, and there were a few [additional
steps](https://docs.funkwhale.audio/installation/index.html#nginx) I had to
take. With all that complete, I had transitioned successfully. I already had SSL
certificates, but if that's also a requirement, they can easily be provisioned
using [Certbot](https://certbot.eff.org/).

## Object Storage Setup

In my old setup, I leveraged Funkwhale's ability to [in-place import
music](https://docs.funkwhale.audio/admin/importing-music.html). I transferred
about 70GB worth of music to my VPS (using Syncthing <3), filling the disk
almost entirely (_98%_).  It was a temporary solution for a road trip, and I
knew I couldn't keep it that way for long. Funkwhale has the ability to leverage
S3-compatible object storage, and Linode, the provider I already use for my VPS,
offers object storage. Any of the other major cloud providers will also do the
trick; I just went with what was easiest. On the Linode side, there's not much
to it. I created a new bucket, labeled it accordingly, created an access key,
and that was it. The Funkwhale side proved to be a bit challenging, but not, it
turns out, due to configuration. Well, _technically_ it was.

The relevant configuration options on the Funkwhale side, in the `.env` file:
```
## External storages configuration
# Funkwhale can store uploaded files on Amazon S3 and S3-compatible storages (such as Minio)
# Uncomment and fill the variables below

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_STORAGE_BUCKET_NAME=
# An optional bucket subdirectory were you want to store the files. This is especially useful
# if you plan to use share the bucket with other services
# AWS_LOCATION=

# If you use a S3-compatible storage such as minio, set the following variable
# the full URL to the storage server. Example:
#   AWS_S3_ENDPOINT_URL=https://minio.mydomain.com
AWS_S3_ENDPOINT_URL=

# If you want to serve media directly from your S3 bucket rather than through a proxy,
# set this to false
# PROXY_MEDIA=false

# If you are using Amazon S3 to serve media directly, you will need to specify your region
# name in order to access files. Example:
#   AWS_S3_REGION_NAME=eu-west-2
# AWS_S3_REGION_NAME=

# If you are using Amazon S3, use this setting to configure how long generated URLs should stay
# valid. The default value is 3600 (60 minutes). The maximum accepted value is 604800 (7 days)

# AWS_QUERYSTRING_EXPIRE=

# If you are using an S3-compatible object storage provider, and need to provide a default
# ACL for object uploads that is different from the default applied by boto3, you may
# override it here. Example:
#    AWS_DEFAULT_ACL=public-read
# Available options can be found here: https://docs.aws.amazon.com/AmazonS3/latest/userguide/acl-overview.html#canned-acl

AWS_DEFAULT_ACL=
```

I've included the comments. The entire file is commented, and generally easy
enough to figure out. On the Linode side, when I generated the access key, it
provided me an _Access Key_ and a _Secret Key_. I had already created a bucket,
and so I had the _Bucket Name_. The challenge for me was what the _Endpoint URL_
was, and if I needed to set a _Region Name_ and _ACL_. Linode's documentation on
their object storage offering is a bit anemic, and so I made use of their setup
instructions for [using s3cmd with Linode object
storage](https://www.linode.com/docs/products/storage/object-storage/guides/s3cmd/).
From this guide, I was able to both setup `s3cmd`, and also determine what the
_Endpoint URL_ would be. I also set the _Region Name_ and _ACL_ to match what
the UI was showing, but I'm still not certain their necessary. Here's the trick,
and the cause of a few hours-worth of confusion: restarting the Docker
containers wasn't re-reading the `.env` file; I had to completely stop and
re-create them. It wasn't until I ran `docker inspect funkwhale-docker_api_1`
and noticed the environment variables weren't set that I figured this out. Could
be this is common knowledge for Docker-gurus; now I know. With the
configuration in place, and the containers recreated, I was able to upload files
through Funkwhale, and watch them be stored in my Linode bucket. My final
configuration options were as follows:

```
AWS_ACCESS_KEY_ID=<stuff>
AWS_SECRET_ACCESS_KEY=<secret stuff>
AWS_STORAGE_BUCKET_NAME=funkwhale-music-bucket-name
AWS_S3_ENDPOINT_URL=https://us-southeast-1.linodeobjects.com
AWS_S3_REGION_NAME=us-southeast-1
AWS_DEFAULT_ACL=public-read
```

## Next Steps

The downside of Funkwhale's S3-compatible object storage integration lies in how
files are uploaded. One cannot simply ~~walk into~~ upload files to the bucket;
music must be uploaded through Funkwhale's API (via web or other means), and
then Funkwhale stores it accordingly (like for local uploads). I have a lot of
music, and I can't be asked to manually upload it all. That's, like, 2 hours of
half-hearted work. No, instead, the obvious solution is to build a script that
can automatically upload any new music from my local music directory to
Funkwhale automatically. What I'm considering now is how I want to do that. I
could leverage systemd to watch my local music directory, and run the upload
script whenever new music is uploaded. Could even expand it to remove music
whenever I delete it locally, though that seems a bit odd. I could instead setup
a cron or systemd-timer to run at a set interval, and check for any new files
since the last run, and upload them. Regardless of the trigger, the upload
functionality should ideally avoid duplicates, run in a non-blocking fashion,
maybe batch upload files, and be low impact on my desktop. So that's next.
