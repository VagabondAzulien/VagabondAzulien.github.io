---
tabtitle: "Syncthing on the Steam Deck"
title: "Setting up Syncthing on the Steam Deck (Updated!)"
topics: [gaming, technology]
pub: "2022-07-12"
short_desc: "Syncthing is an incredible tool that I use to keep pictures,
music, notes, and games synchronized across multiple platforms. The form
factor of the Steam Deck makes it a perfect emulation target, and Syncthing
can help keep games and saves in-sync with other machines."
---

# Syncthing on the Steam Deck (Updated!)

## Update

Turns out, when you update the SteamOS, it completely over-writes the operating
system. All of the setup I had originally written was great, if I never update,
which is unacceptable. Not all is lost; the quest simply gets harder. If I can't
rely on system-wide services, then I rely on user services.

### The Wrong Way: System-Wide Services

My first attempt was to setup Syncthing as a system-wide service managed by
`systemd`, installed via `pacman`. There are several problems with this. First,
it requires disabling the read-only file-system. Next, `pacman` is not setup nor
reliable, since every SteamOS update will over-write any changes I make to any
of the read-only file-system, including the directories that `pacman` relies on.
Related, the update will also erase the Syncthing package. This means I either
never update (inadvisable, and unacceptable), or I setup Syncthing not in the
read-only file-system.

### The Right Way: User Services

systemd allows for non-root-based services, called user services. The Arch Wiki
[systemd/User](https://wiki.archlinux.org/title/Systemd/User) article describes
this functionality much more than I will. Here are the relevant details:

- User services can be enabled to start when a user logs in
- Service files are stored in the user's home directory (specifically
    `~/.config/systemd/user`)
- No root privileges are required. No modifying the read-only file-system

## Syncthing

Syncthing is incredible. I've [written about it
before](2020/07/19/syncthing-part-1.html), but the setup here is a bit more
involved. The Steam Deck runs Arch Linux (and have I told you yet today that I
do too?), so the Arch Wiki [article on
Syncthing](https://wiki.archlinux.org/title/Syncthing) gives some good insight.
When I initially started this process, I installed the SyncthingGTK application
from the Discover Store. This means it is a Flatpak application, and so doesn't
require elevated user privileges. I also tried the Syncthingy application, which
explicitly calls out Steam Deck users. However, both require running the Flatpak
in the background (like some users do for Discord or Spotify). I don't like
this, it feels off, and thus I sought a different approach.

## SSHD: Still Incredibly Useful

I got real tired real quick of using the on-screen keyboard. After
complaining, a friend recommended I enable `sshd` and just remote in to the
device. Doing so was a breeze, and I recommend to others who don't have a
physical keyboard they can plug into their device. Drop to desktop mode
(hold the power button for a few seconds, and select the option), and start a
terminal (default is Konsole). Before remotely accessing the device, or using
elevated privileges via `sudo`, I need to set a password for the default user,
_deck_. In the terminal, type `passwd` and set it (and then put it in your
password vault so you don't forget. You _do_ have a password vault, right?).
Start the service, `sudo systemctl start sshd`, and optionally enable it to have
`sshd` automatically started on each boot (`sudo systemctl enable sshd`). Get
the device IP with `ip addr list`, from my desktop run `ssh deck@ip-address`,
type in the password, and now I'm a grade-A Hackermans.

This setting is not reset on SteamOS updates, that I can tell. Once enabled,
this will always start at boot, and always be on until explicitly turned off. Be
mindful of that if you decide to wander away from your home network; maybe turn
it off in public if you don't need it.

## Setup

There are 2 things required: a systemd service file, and the `syncthing`
binary. Syncthing is written in Go, and a compiled binary can be downloaded that
has no dependencies or installation requirements. It can be downloaded from
the [Syncthing
Releases](https://github.com/syncthing/syncthing/releases/tag/v1.20.3) page for
many platforms and architectures. The Steam Deck is a Linux platform, using the
AMD64 architecture (or x86_64), so I grab that one. I'll note here, since I have
SSH access, I do all the editing and downloading on my desktop, and then
transfer the files using `scp` to the Deck. All of these steps can be done on
the Deck itself, without SSH access. Once the proper tarball has been
downloaded, extract it, and within will be the `syncthing` binary, ready to
rock. I copy/move the binary to `~/.local/bin/syncthing` on the Deck. The exact
location is less important than ensuring the binary is within my home directory
on the Deck.

The systemd serivce file can also be taken from the extracted tarball, but
requires modification. In the tarball, it is
`etc/linux-systemd/user/syncthing.service`. Copy this file to
`~/.config/systemd/user` on the Deck, and edit the "ExecStart" line in the
"[Service]" section from

```
...
[Service]
ExecStart=/usr/bin/syncthing serve --no-browser --no-restart --logflags=0
...
```

to


```
...
[Service]
ExecStart=/home/deck/.local/bin/syncthing serve --no-browser --no-restart --logflags=0
...
```
(or wherever you decided to put the local `syncthing` binary)

With everything in place, I can now enable and start the Syncthing user service:

```
systemctl --user enable syncthing.service
systemctl --user start syncthing.service
```

Since I don't have a physical keyboard plugged in, I modify my SSH command
slightly to forward the Syncthing web-UI from the Deck to my local machine:

```
ssh -L 31337:deck-ip-goes-here:8384 deck@deck-ip-goes-here
```

Now, on my local machine I can open one tab to `localhost:8384`, to show
Syncthing on my local machine, and another tab to `localhost:31337` to show
Syncthing on my Deck. From here, I add my local machine as a device on my Deck,
and begin sharing folders. 

## Closing Thoughts

I've been using this setup for about a week now. I've synced almost 20GB of
files, including configurations and saves for Retroarch. It works after
restarts, OS and client upgrades, and waking the device from sleep. It sits
quietly in the background, without having to start up applications. The biggest
problem is that it doesn't automatically update to the newest version of
Syncthing. It's also a bit involved to setup. To that end, I've written a tool
to help with setup: [Steam Deck Syncthing
Setup](https://gitlab.com/VagabondAzulien/steam-deck-syncthing). I'm still
finishing it up, but I intend to make use of it to keep my version of Syncthing
up-to-date. If you use it, let me know!
