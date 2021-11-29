---
     tabtitle: "Brief Exploration of Syncthing"
     title: "Brief Exploration of Syncthing"
     topics: [technology]
     pub: "2020-07-19"
     short_desc: "Syncthing is an incredible tool. In this post, I want to
     explore setting it up, and then some uses I've found for it."
---

# A Brief Exploration of Syncthing

Syncthing is an incredible tool. Many days past I stumbled upon it as an
alternative to Dropbox. It's different from Dropbox, or similar services,
though, in a number of ways. For one, Syncthing is a peer-to-peer
synchronization program, whereas Dropbox is a centralized file storage and
synchronization service. When you setup and use Syncthing, the files only ever
live on whichever peers you setup. This is different from Dropbox, or similar
services, where files live on their servers. There's more to it, and for all the
details, the [Syncthing](https://syncthing.net/) website provides plentiful
information.

In this post, I want to discuss how to setup Syncthing, and some use-cases for
it. In future posts, I want to explore setting up custom relay servers, and
perhaps some more use-cases as well.

## Setup

Install the appropriate package for your operating system. Syncthing is
available on just about every OS out there. Syncthing already has [thorough
installation
documentation](https://docs.syncthing.net/intro/getting-started.html), so I
won't re-write what's already available. I will discuss how I setup my Syncthing
instead.

On my desktop, running Arch Linux, I installed the necessary package:

```
$ sudo pacman -S syncthing
```

When I was running Gnome, I also installed `syncthing-gtk` to provide a tray
icon. After my switch to KDE Plasma, the Syncthing application displays a tray
icon by default, and so I removed the now unnecessary package. When I had a
Windows partition, I also installed `SyncTrazor` for a tray icon.

The second device of choice is my Android phone, where I installed the Syncthing
app (helpfully available on F-Droid too!).

With packages installed on both devices, I then followed the guide. All things
considered, it was a very easy process.

## Use-Case: Music

One of the most immediate uses I had for Syncthing was music. I finally decided
to drop all streaming services, and start buying my music. As a result, I
suddenly had a growing music library available on my desktop.  This was the
primary reason I decided to try Syncthing: to get music files from my desktop
onto my phone. After setup, syncing was a breeze. The new problem became space:
I have quite a bit of music now, and I don't necessarily want all of it on my
phone. Conveniently, Syncthing allows for creating a `.stignore` file, which
tells Syncthing which files to exclude from synchronizing. The
[documentation](https://docs.syncthing.net/users/ignoring.html) provides a great
breakdown of available options. One challenge is that the `.stignore` file is
**not** synchronized. To get around this, I setup my ignore file to include a
second file, which _does_ get synchronized. That file lists every directory and
subdirectory in my music folder, and then ends with `**/*`. For any directory or
subdirectory (generally artist and album, respectively) that I want to sync, I
place a `!` before it. The eventual plan is to automatically update the file
whenever new music is added to the directory. When I get around to that, I'll
almost certainly post about it.

## Use-Case: Notes / To-Do

Not long after music, I started looking around for a good to-do / note-taking
app for my phone. I wanted an application that was simple, without bells and
whistles. I tried a few before settling on
[Markor](https://gsantner.net/project/markor.html). This app is wonderful.
Everything I want, with almost nothing I don't. It's open-source, actively
developed, available on F-Droid; it works on local files, and _that's it_. I
started using it to track my gym workouts, make grocery lists, or track
suggestions for media. As long as I was on wi-fi, those files were waiting for
me on my desktop. Very convenient, simple, and effective.

## Use-Case: Pictures

Another straight-forward use case: synchronizing pictures. As I continue to
"de-Google" my life, I needed a replacement for Google Photos. I have a Flickr,
but I'm not certain that I'll hang onto it. For now, I just need a simple way to
synchronize pictures between my phone and my desktop, and Syncthing provides
that.

# 100 Days
I'm writing this post as part of
[#100DaysToOffload](https://100daystooffload.com), an initiative to inspire
writing habits. Perhaps you could do the same.

# Sources

* [Syncthing](https://syncthing.net/)
* [SyncTrayzor](https://github.com/canton7/SyncTrayzor)
* [Markor](https://gsantner.net/project/markor.html)
