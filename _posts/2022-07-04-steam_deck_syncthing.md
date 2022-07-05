---
tabtitle: "Syncthing on the Steam Deck"
title: "Setting up Syncthing on the Steam Deck"
topics: [gaming]
pub: "2022-07-04"
short_desc: "Syncthing is an incredible tool that I use to keep pictures,
music, notes, and games synchronized across multiple platforms. The form
factor of the Steam Deck makes it a perfect emulation target, and Syncthing
can help keep games and saves in-sync with other machines."
---

# Syncthing on the Steam Deck

Syncthing is incredible. I've [written about it
before](2020/07/19/syncthing-part-1.html), but the setup here is a bit more
involved. The Steam Deck runs Arch Linux (and have I told you yet today that I
do too?), so the Arch Wiki [article on
Syncthing](https://wiki.archlinux.org/title/Syncthing) gives some good insight.
When I initially started this process, I installed the `SyncthingGTK`
application from the Discover Store. This means it is a Flatpak application, and
so doesn't require elevated user privileges. After setting it up, I realized
that I would need to run the application in order for the Syncthing daemon to
start and sync. I see in the options that `SyncthingGTK` can be configured to
start at launch minimized, and this _may_ resolve that issue. I decided to go a
different route and setup Syncthing how I'm used to it. This required disabling
the Steam Deck's read-only file system, configuring `pacman`, installing the
Syncthing daemon, enabling and starting the service, and then configuring
Syncthing through the web-UI.

### Preface

Disabling the Steam Deck's read-only file system is not advised if you're not
comfortable with the reality that you can seriously mess up the device with
little to no effort. Use the `SyncthingGTK` option, and just start it when you
need to sync. Heck, do what I'm too lazy to do, and check if by enabling the
options to start it on login minimized, it still synchronizes in the background!
If you want to do what I did (which, as a final warning, may not be a good
decision), read on.

I got real tired real quick of using the on-screen keyboard. After
complaining, a friend recommended I enable `sshd` and just remote in to the
device. Doing so was a breeze, and I recommend to others who don't have a
physical keyboard they can plug into their device. Drop to desktop mode
(hold the power button for a few seconds, and select the option), and start a
terminal (default is `Konsole`). Start the service, `sudo systemctl start sshd`,
and optionally enable it to have `sshd` automatically started on each boot
(`sudo systemctl enable sshd`). Before remotely accessing the device, or using
elevated privileges via `sudo`, I need to set a password for the default user,
`deck`. From the same terminal, type `passwd` and set it (and then put it in
your password vault so you don't forget. You _do_ have a password vault,
right?). Next, get the device IP with `ip addr list`, from my desktop run `ssh
deck@ip-address`, type in the password, and now I'm a grade-A Hackermans.

### Disable SteamOS Protections

Using the `steamos-readonly` command, I can enable, disable, and check the
status of the read-only protections. For now, I will disable them:

```
sudo steamos-readonly disable
```

### Pacman Configuration

Next configure `pacman`:

```
sudo pacman-key --init
sudo pacman-key --populate
sudo pacman-key --refresh-keys
```

This will initialize the `pacman` key-ring, populate it with the default signing
keys provided with Arch, and then refresh those keys. Without this step, when I
would try to install I would get errors About untrusted and corrupt packages.

### Install Syncthing

Install the package:

```
sudo pacman -Syu syncthing
```

Next, enable and start the daemon. I used a user service, since the `deck` user
should be the only user ever logging in. It can be set up as a server-wide
service too; check the wiki. Here are the user service steps:

```
sudo systemctl --user --machine=deck@.host enable syncthing
sudo systemctl --user --machine=deck@.host start syncthing
```

A `sudo systemctl --user --machine=deck@.host status syncthing` should show
happy results.

### (Optional) Re-Enable SteamOS Protections

```
sudo steamos-readonly enable
```

### Configure Syncthing

Before returning to game mode, I add a few non-Steam applications to Steam, all
of which were installed using the Discover Store: Firefox, Minetest, and
Retroarch. I opted to return to Game Mode for the Syncthing configuration.
Regardless, the following steps are performed back on the Deck with the
on-screen keyboard (or a physical one attached to the device.) Technically, I
could leverage `ssh` to port-forward the Syncthing web-UI to my desktop.

```
ssh -L 31337:deck-ip-goes-here:8384 deck@deck-ip-goes-here
```

I did not, and suffered through the on-screen keyboard. Within a web browser on
the Deck get to the Syncthing web-UI by going to `localhost:8384`. Once there, I
added my desktop as a device, and shared several folders from my desktop to my
Deck. Those details mostly center around Retroarch, a topic I hope to cover
next.
