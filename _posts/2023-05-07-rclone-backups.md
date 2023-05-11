---
     tabtitle: "Automatic Backups with RClone"
     title: "Automatic Backups with RClone, systemd, and Backblaze"
     topics: [technology]
     pub: "2023-05-07"
     short_desc: "RClone is a command-line utility for interacting with an
     incredible number of cloud services. Backblaze is a reliable and
     inexpensive cloud storage provider. With systemd timer units, I setup a
     simple and reliable backup solution."
---

# Automatic Backups with RClone, systemd, and Backblaze

## Quick Note

Backups are not complicated. They may seem like it, but in reality the
complications arise from restoration. If you're not doing anything fancy with
your data now, then don't do anything fancy with your backups. Follow the 3-2-1
methodology: 3 copies of (important) data, in 2 different locations, 1 of which
is off-site. Many others have written about this in better detail than I ever
can; Jeff Geerling has a great article and several videos about it [on his
site](https://www.jeffgeerling.com/blog/2021/my-backup-plan). The time (and
often money) investment now can reduce worry, stress, and loss should the data
you care about ever become unusable.

(There are no affiliate links in this post, nor was I paid to recommend any
product or service.)

# My Needs

Backups are as important as the data you have. If all you've got is a directory
full of meme GIFs that you don't mind losing, then backups may be a waste of
time and money. I have recently taken to buying as much of my music as possible
(especially through Bandcamp, and especially on Bandcamp Fridays!). While much
of the music I buy does exist on a remote server at a company somewhere, the
cost of having to re-download and re-organize all of it well outweighs the cost
of proper backups. Not to mention the music which I can't get anywhere else
anymore. Nor to further mention the other data which I have. All of this is to
say: backups are worth it to me.

Recently I wanted to setup NFS on my home network. I was concerned about messing
something up, and erasing the directory I had intended to share, so I wanted to
backup the data. For a while I've been intending to setup backups (as everyone
probably does), but it was never a priority. This project helped to prioritze
it. I had read about [RClone](https://rclone.org/), a command-line utility for
interacting with an incredible number of cloud services. I messed around a bit
with it, found it to my liking, and started shopping around for a cloud storage
solution. Enter [Backblaze](https://www.backblaze.com/). The folks that publish
all those hard-drive stats? Turns out they also run a business where they
provide cloud storage. It's inexpensive, reliable, and straight-forward. The
last step was to automate it with systemd timer units.

## Backblaze Setup

* [Backblaze Site](https://www.backblaze.com/)
* [Backblaze Docs](https://www.backblaze.com/help.html)

First step is to setup Backblaze. Create an account, verify email address, all
that jazz. I'd recommend enabling multi-factor authentication on the
**Account** -> **My Settings** page, under **Security**. Next, click on the 
**Account** -> **Application Keys** page, and generate a new key. Fill in the
blanks (I gave my key full access to all buckets), copy the important bits, and
store them somewhere safe (like your password vault).

## RClone Setup

* [RClone Site](https://rclone.org/)
* [RClone Backblaze B2 Page](https://rclone.org/b2/)

Download and install RClone. Next run `rclone config` and walk through the
prompts. I'm using Backblaze, so I select "Backblaze B2" as my storage backend.
Then I add the application key ID and application key secret (key) at the
relevant prompts. For all of this configuration, I named the remote "backblaze",
though a shorter name can make commands easier. Regardless, verify the
configuration is setup properly by running `rclone lsd backblaze:`, which will
list buckets. Unless a bucket was already configured, nothing will show up, and
also there won't be any errors.

## Backup Configuration

Now, figure out how you want to backup your data. I have a [BTRFS RAID setup
with multiple sub-volumes](/2020/06/14/setting-up-btrfs.html), each for a
different data type: one for Books, one for Music, and so on. Since creating a
bucket doesn't cost anything, I decided to split my backups similarly. I created
the buckets I wanted, and did a "manual" RClone sync of the data.

`rclone sync --fast-list --transfers 20 /path/to/Books
backblaze:bucket-for-Books-backups`

The "--fast-list" and "--transfers" options are specified on the [RClone
Backblaze B2 page](https://rclone.org/b2/), along with some others that may be
of interest.

At this point, my data was "backed-up", and I could muck about with it more
confidently. Also, at this point, configuring back-ups is done. Run those RClone
sync commands once a week, and all is set. I don't want to remember to do
things, though.

## Automating the Process

The first thing to do is create a user-agnostic location for the configuration
file and some additional files. I chose `/etc/rclone`, and copied the RClone
configuration file generated previously to this directory as `backblaze.conf`.

Next, I created a filter file. RClone has extensive [filtering
options](https://rclone.org/filtering/). For my current needs, a single file
will suffice.

### default.filter
```
# Exclude BTRFS snapshot directories
- .snapshots/**
# Exclude Syncthing configuration directories
- .stfolder/**
```

systemd timer units ( [[Arch
Wiki](https://wiki.archlinux.org/title/Systemd/Timers)]
[[Manual](https://man.archlinux.org/man/systemd.timer.5)] ) are triggers that
activate on a schedule. That schedule can be dynamic (relative to a
previous/other trigger), or static (at 6:15 every day). A timer unit triggers a
service unit, which does the work. For my backups, I decided to run a sync every
hour, at sometime between the 15 and 45 minute mark of that hour. To simplify
having multiple timer units that all do the same thing, I setup a template unit
(see the **Note** here: [Arch
Wiki](https://wiki.archlinux.org/title/Systemd#Using_units)).

### rclone-backup@.timer
```
[Unit]
Description=RClone Backup Timer Template

[Timer]
# Run every hour, sometime between the 15 minute and 45 minute mark
OnCalendar=*-*-* *:15:00
AccuracySec=30min
RandomizedDelaySec=5min

# The %i is whatever value is after the "@" for the configured unit. For
# example, rclone-backup@Books.timer will run the rclone-backup@Books.service
Unit=rclone-backup@%i.service

[Install]
WantedBy=timers.target
```

Then I can `enable` and `start` a timer for each directory to backup. To
minimize configuration, I also setup the service file to be a template. This
requires a bit of inflexible coordination: the directory name must match to a
part of the bucket name.

### rclone-backup@.service
```
[Unit]
Description=RClone Backup of %I

[Service]
Type=simple
ExecStart=/usr/bin/rclone sync -v --config "/etc/rclone/backblaze.conf" --fast-list --transfers 20 --filter-from "/etc/rclone/default.filter" /path/to/%i/ backblaze:bucket-for-%i-backups
```

The `--config` option allows us to specify the configuration in the `/etc`
directory. I include `-v` to have some additional output in the journal.
Again, `--fast-list` and `--transfers` are used to speed up the process and keep
costs lower. Then I `--filter-from` the "default.filter" file.

Place each of these files (`rclone-backup@.timer` and `rclone-backup@.service`)
into `/etc/systemd/system`. For each directory, enable and start the timer
unit; `systemctl enable rclone-backup@Example.timer` and `systemctl start
rclone-backup@Example.timer` will backup `/path/to/Example/` to the
`bucket-for-Example-backups` bucket.

# Next Steps

I would like to get some sort of metrics and dashboards setup to track backup
status and statistics. It could be very useful to be notified if a backup ever
fails.

Eventually, I'll upload this to a repository somewhere for ease of access and
backup. When I do, I'll update this post.
