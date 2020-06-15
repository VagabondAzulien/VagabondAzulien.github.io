---
     tabtitle: 'Setting Up a BTRFS RAID-1'
     title: 'Using BTRFS to setup a simple RAID, with subvolumes, snapshots and
     backups'
     topics: [technology]
     pub: '2020-06-14'
     short_desc: 'BTRFS is a file system, and includes built-in functionality
     for RAID. I decided to use it for the storage disks in my desktop. Here is
     how I set it up, using subvolumes, with snapshots and backups.'
---

# BTRFS: Smooth as Butter

I have a habit of calling BTRFS "butter-F-S." Conveniently in text I don't feel
a need to say that, because it's easier to type out BTRFS than "butter-F-S", as
opposed to being easier to say the latter than the former. Regardless, BTRFS is
a file system, which can be thought of as the organization system used by a hard
drive to store files. File systems provide the functionality necessary for
handling data; without one, data would exist on a disk with no means of (simple,
reliable) access, management, or use. Every operating system provides the
necessary configurations for using at least one file system, and often times can
be expanded to understand more file systems, as is the case with Linux. If
you're used to Windows, you'll be primarily familiar with two file systems:
NTFS, and FAT. If you're familiar with Linux, you'll have probably dealt with
those, as well as EXT. If you're adventerous, you have have tried additional
file systems such as ZFS, or BTRFS.

When I returned to Linux full-time on my desktop, I decided I wanted to setup a
storage system. I initially shopped around for a NAS: network-attached storage.
This would be a separate device, basically a motherboard with hard-drives. It
would include software for storing data reliably, as well as applications for
serving that data, such a  Plex. There are many top-rated off-the-shelf options
available, but many are costly, propietary, and lock you in to that solution. I
decided to go with something a bit more readily available, and turn two existing
3 terrabyte drives into a storage system that would live as part of my desktop.
The remainder of this post will deal with how I setup BTRFS on my Linux desktop,
using sub-volumes, creating automated snapshots, and setting up a back-up
schedule.

## Setting up BTRFS

Linux has "first-class" support for BTRFS, which was a deciding force between it
and ZFS. (Though, recently, ZFS has made some strides as well.) The only
requirements necessary for using BTRFS is to install the `btrfs-progs` program,
which is required for basic operations. With requirements done, the next step is
to setup the filesystem on your disk of choice. This will delete all information
on your disk, so only do this when you're certain any existing data has been
backed-up, or you don't mind losing it.

```
mkfs.btrfs /dev/partition
```

I decided to go with a partitionless setup, which is a slightly modified version
of the above command. The above command also allows for adding a disk label, as
well as a few other options; `man mkfs.btrfs` will give you all the details. I
decided to call my BTRFS storage system my "Bag of Holding."

```
mkfs.btrfs -L BagOfHolding /dev/sdg
```

Creating a partitionless setup removes the MBR or GPT partitioning schemes, and
relies on subvolumes to simulate partitions. Because I'm only using these disks
for storage, and I won't be booting from them, this seemed like the way to go.

My setup will take two drives, and combine them together into a RAID-1. In order
to allow for me to get the data from the drives into my new RAID, I did one disk
at a time, and moved data between them, I then balanced the RAID.

## Configuring a BTRFS RAID

At this point, I have two separate drives. One of my drives has all my data on
it, the other drive is a raw, partitionless filesystem. At this point, we can
leverage BTRFS to combine both our disks into a single "device", and then
balance it. All these commands will leverage the `btrfs` command, which needs to
be run as root.

First, mount one of the drives. In my case, I mounted the drive with data

```
mount -t btrfs /dev/sdg /mnt/BagOfHolding
```

Next, I added my second device to the mounted file system

```
btrfs device add /dev/sdh /mnt/BagOfHolding
```

At this point, we have a filesystem with two devices, but the data and metadata
hasn't been balanced yet. To simply balance the data, and replicate a RAID-0
setup, you would run the `btrfs balance` command, specifying the
mounted filesystem. In my case, I wanted to replicate a RAID-1 setup, having the
two disks mirrored instead of striped. The command is modified to include a
"balance filter":

```
btrfs balance -dconvert=raid1 -mconvert=raid1 /mnt/BagOfHolding
```

This command will take time, since it has to re-balance the data across the
devices. A convenient time for a short aside:

### Buzzwords of Butter

- Copy-on-Write (COW): Basically, only make copies to data when there are
    written changes to it. I don't fully understand Copy-on-Write, and is
    possibly a good candidate for a future post.
- Subvolumes: Like a partition, but not a block device. The BTRFS Wiki defines
    it as "an independently mountable POSIX filetree." I think of subvolumes as
    "software partitions" which I'm sure is both wrong and infuriating to people
    who know more about it than I do.
- Snapshots: A snapshot is a subvolume that shares its data with another
    subvolume, using copy-on-write. This means if there are no changes to the
    underlying data, a snapshot is basically just a reference to the exactly
    same data as the initial subvolume. As changes get made, the snapshot
    references a copy of "old" data, as opposed to the new data. Thus, a
    snapshot represents data at a specific point in time.

## Setting up Subvolumes

At this point, I have a single device made of two disks. The device, when
queried using `btrfs filesystem show` shows the total available and used space,
and the individual disks composing it. Creating subvolumes is optional; by
default, a BTRFS filesystem has one subvolume (with id 5) as the "root." If you
mount the device, you'll mount that, and see the entire device. I wanted a bit
more organization, and options for snapshots, so I created a number of
subvolumes for different files: Books, Code, Documents, Games, Misc, Music,
Pictures, Videos. I mount each separately, and then sym-link directories in my
home directory to a corresponding subvolume.

Creating a subvolume is very straight forward, using the `brtfs subvolume
create` command. I made many, as mentioned before, and I'll walk through how I
setup the Books subvolume. I followed the same steps for all other subvolumes.

First, I created it:

```
btrfs subvolume create /mnt/BagOfHolding/Books
```

Then, I configured it to automatically mount. This involved adding a line to my
fstab file:

```
...
UUID=658cc4e0-93e1-43b5-b068-d889b44ae98d       /mnt/BagOfHolding/Books      btrfs  subvol=/Books,defaults,nofail,x-systemd.device-timeout=5 
...
```

Looks very similar to other entries, except that the option `subvol=/Books` is
necessary! This whole line tells the file system to mount the BTRFS subvolume
located at Books _relative to the "root" subvolume_, to the mount point
"/mnt/BagOfHolding/Books". The other important thing to remember is that
subvolumes are not block devices. For the BTRFS device, there is only one block
device, and that's the RAID we setup earlier. If you run `btrfs filesystem show`
you'll see the device has a single UUID, despite having the two individual
disks. In fact, if you were to mount either of the disk devices, you would mount
the raid; in my case, if I were to use `/dev/sdg` or `/dev/sdh` instead of the
UUID, it would do the same thing. UUIDs are more reliable, though, so I tend
towards them. My fstab has a line like the above for each subvolume. Once that's
done, unmount the RAID, and then either run `mount -a` or restart to get each
individual subvolume mounted. The final step I did was to symbolic link
directories from my home directory to the corresponding subvolumes. Following
with Books, I did `ln -s /mnt/BagOfHolding/Books Books` from my home directory.
Now, if I `cd ~/Books` I get to the subvolume on my RAID.

## Scheduling Snapshots

With the RAID established, and subvolumes created, mounted and linked, I now can
schedule automatic snapshots. An easy way to do so is with a program called
Snapper. Installing that provides the application, as well as schedules both via
cron and Systemd. Because I'm running Arch, we'll rely on the Systemd timer.
Before that, we need to create a Snapper configuration.

```
sudo snapper -c books create-config /mnt/BagOfHolding/Books
```

This will create the configuration file in "/etc/snapper/configs/". The
configuration includes limits on how many snapshots to keep of different types
("hourly", "weekly", etc..). The defaults seemed sane enough for me. Without a
cron scheduler, though, nothing else happens. (If you have a cron scheduler,
then it will have started automatically and will run accordingly). The final
step is to enable and start the "snapper-timeline" timer. If desired, modify the
timer frequency (I believe the default is hourly, which is good enough).

One last thing to do for Systemd is to also enable and start the
"snapper-cleanup" timer, which will cull snapshots down to the configured amount
from the configuraiton file.

An interesting thing about snapshots is that, unless something has changed, they
won't take up space. Creating 10 snapshots will not replicate data 10 times.
What each snapshot will capture are any changes that have been made to the data.

## Creating Backups from Snapshots

The final phase of my BTRFS journey is to establish backups. One thing that must
be emphasized: **SNAPSHOTS ARE NOT BACKUPS**. They can be used to make backups,
though. The way I'm doing that currently is with a program called snap-sync.
snap-sync will iterate through each Snapper config, and send a snapshot from
each to a remote BTRFS-formatted source. In my case, the remote source is an
external hard drive. I formatted it similar to my RAID drives, without a
partition. Once done, I ran `snap-sync` as root, which provides guidance for
choosing a disk, and walks through each Snapper config. I ran it once, to get
each directory established on the external drive. The manual (`man snap-sync`)
includes example Systemd timers, which I used to create a timer and service in
"/usr/lib/systemd/system". Then, I enabled and started the timer. The example
runs once a week, though I think I may update that to once a day.

## Conclusion

With that, I feel I have a good solution to my storage needs. I can keep all my
data on a RAID drive with backups, accessible easily from the primary machine I
use. I further synchronize music and pictures to and from my phone using
Syncthing, which will be an upcoming topic of discussion. Some next steps:

- setup and configure Calibre for my books
- better configure Demlo for my music
- look into accessing my RAID from my Raspberry Pi, perhaps via NFS, and
    leveraging wake-on-lan, to allow for streaming media remotely whenever,
    without having to leave my desktop on

### Sources

|----|
|[btrfs on the Arch Wiki](https://wiki.archlinux.org/index.php/Btrfs)|
|[Snapper on the Arch Wiki](https://wiki.archlinux.org/index.php/Snapper)|
|[snap-sync](https://github.com/wesbarnett/snap-sync)|
|[The BTRFS Wiki](https://btrfs.wiki.kernel.org/index.php/Main_Page)|
