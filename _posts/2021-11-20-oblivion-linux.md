---
     tabtitle: "Oblivion on Linux"
     title: "Oblivion on Linux, with Mods!"
     topics: [gaming]
     pub: "2021-11-20"
     short_desc: ""
---

Oblivion holds a special place in my heart. I remember spending a summer in the
town I went to college in, and playing Oblivion almost every day while listening
to Dream Theater's _Systematic Chaos_. Back then, I wasn't aware of modding, so
it was literally just vanilla Oblivion for hours upon hours. I also used
Windows, so the game would run fine. Now, things have changed. The easier issue
to deal with is playing Oblivion on Linux. Thanks to Valve, Oblivion runs
excellent with Proton out of the box. The more challenging issue is mods, and
that's what this write-up is all about!


# Vanilla Oblivion

Starting from the beginning, Oblivion is available on many platforms, but my
experiences here will assume the Steam installation. The primary difference will
be with respect to the how the tools used to mod Oblivion are run. I've got the
Game of the Year edition, which is Steam ID `22330`.


# Modding Tools

Much of modding Oblivion is done with the help of additional tools. A mod
manager is used for installing and configuring the mods. There are several
options for Oblivion, and the one I've been suggested and use is called `Wrye
Bash`. Mod load order is also important, and the tool I'm using to help with
that is `LOOT`. Finally, `TES4Edit`, `TES4LODGen` and `BethINI` each helps with
performance and configuration.

I have the following directory structure setup for my mods:

```
OblivionMods
  |- Archives
  |- Backups
  |- Tools
  |- WryeBash
```

_Archives_ is where I store the actual archives of the mods I use. _Backups_ is
where I store any relevant backups for my Oblivion game, such as saves or
configuration files for the mods. _Tools_ is where I put the executables for all
the tools I mentioned above. _WryeBash_ is used to store the unarchived mods
(which are called "projects") and mod data that `Wrye Bash` uses.

Because each of these tools is run using Proton (or Wine for non-Steam
installs), I also have a set of aliases configured.

## Wrye Bash

[Project Link](https://github.com/wrye-bash/wrye-bash) || [Homepage](https://wrye-bash.github.io/) || [Nexus Link](https://www.nexusmods.com/oblivion/mods/22368)

`Wrye Bash` is involved. I don't know how to use it fully. There are a few
guides that helped me learn how to use it enough to get mods installed and
configured though. The first, and very relevant, is at [Shrine of
Kynareth](https://www.shrine-of-kynareth.de/wrye-bash-on-linux). I referenced
this guide, and the
[other](https://www.shrine-of-kynareth.de/wrye-bash-for-beginners-part-1-installation-and-installers-tab)
[written](https://www.shrine-of-kynareth.de/wrye-bash-for-beginners-part-2-load-order-bashed-patch-and-savegame-profiles)
[guides](https://www.shrine-of-kynareth.de/wrye-bash-for-beginners-part-3-ini-edits-tools-and-tricks)
to learn how Wrye Bash works and what to setup. I also learned some tricks from
the [Oblivion Comprehensive Modding Guide by
Dispensation](https://www.nexusmods.com/oblivion/mods/49898).

### Setup

The easiest option is to use the stand-alone executable from the GitHub releases
page. Extract the archive, and then use Proton to run the executable in the
_Mopy_ directory. This is the alias I use; replace directories accordingly:

```
alias oblivion-wyre='STEAM_COMPAT_DATA_PATH=/path/to/steam/directory/steamapps/compatdata/22330/ \
                     STEAM_COMPAT_CLIENT_INSTALL_PATH=/path/to/steam/directory/ \
                     /path/to/proton/proton run /path/to/OblivionMods/Tools/Mopy/Wrye\ Bash.exe'
```

Additionally, I copy the _Mopy/bash_default.ini_ file to _Mopy/bash.ini_ and set
the `sOblivionMods` to "Z:\path\to\OblivionMods\WryeBash", `sBashModData` to
"Z:\path\to\OblivionMods\WryeBash\Bash Mod Data", `sInstallersData` to
"Z:\path\to\OblivionMods\WryeBash\Bash Installers", and `sOblivionPath` to
"Z:\path\to\steam\steamapps\common\Oblivion". In Wine, `Z:` references your
local file system. Theoretically, because Wine is awesome, you may be able to
use Linux file system paths in the configuration, but I went with this.

### Usage

The guides above provide a very thorough explanation of use. Of note: `Wrye
Bash` in Wine does not like drag-and-drop actions, so don't do them. I don't do
anything special with my usage of `Wrye Bash`: run the alias, install mods from
the Installers tab, enable or disable mods from the Mods tab. I generally don't
do anything else.

## LOOT

[Project Link](https://github.com/loot/loot) || [Homepage](https://loot.github.io/)

`LOOT` sets the proper load order for mods. There is a native Linux client, but
I ran into [this issue](https://github.com/loot/loot/issues/1615) and decided to
just use the Windows version. The GitHub releases page includes a 7z archive
with a stand-alone executable, and that's what I used.

### Setup

Download the stand-alone executable, and extract it to _OblivionMods/Tools_.
This is the alias I use; replace directories accordingly:

```
alias oblivion-wyre='STEAM_COMPAT_DATA_PATH=/path/to/steam/directory/steamapps/compatdata/22330/ \
                     STEAM_COMPAT_CLIENT_INSTALL_PATH=/path/to/steam/directory/ \
                     /path/to/proton/proton run /path/to/OblivionMods/Tools/LOOT/LOOT.exe'
```

On first run, it should auto-detect the Oblivion installation and configure
everything accordingly. If it doesn't, there are instructions on the Homepage
for configuration.

### Usage

`LOOT` is pretty straight forward. It references a master list of mods to
determine the optimal load order for all installed mods. I ran into an issue
where `LOOT` couldn't properly download the master list, and so as a work-around
I manually downloaded the master list, and then configured `LOOT` to use that
local file instead of the remote Git repository. If everything works, and the
list of mods is there, then you can run a sort, and apply the changes. `LOOT`
will inform you of any "dirty" mods, which you can use the next tool the clear
up. I ended up keeping `LOOT` open, while stepping through the cleaning
procedure for each mod, until everything looked happy.

## TES4Edit

[Project Link](https://github.com/TES5Edit/TES5Edit) || [Homepage](https://tes5edit.github.io/) || [Nexus Link](https://www.nexusmods.com/oblivion/mods/11536)

`TES4Edit` is the Oblivion version of `xEdit`, which is an incredible tool. All
I use it for is to clean dirty mods. `LOOT` provides a link to the [quick
cleaning guide](https://tes5edit.github.io/docs/7-mod-cleaning-and-error-checking.html#ThreeEasyStepstocleanMods), which gives us exactly the steps required.

### Setup

Download the latest build from GitHub, and extract it to _OblivionMods/Tools_.
This is the alias I use, which runs the "Quick Auto Clean" function; replace
directories accordingly:

```
alias oblivion-wyre='STEAM_COMPAT_DATA_PATH=/path/to/steam/directory/steamapps/compatdata/22330/ \
                     STEAM_COMPAT_CLIENT_INSTALL_PATH=/path/to/steam/directory/ \
                     /path/to/proton/proton run /path/to/OblivionMods/Tools/TES4Edit/TES4EditQuickAutoClean.exe'
```

### Usage

Run the alias, select the problematic file, and click "OK". Only one file can be
cleaned at a time.

## TES4LODGen

[Project Link](https://github.com/TES5Edit/xLODGen) || [Homepage](https://tes5edit.github.io/docs/16-xLODGen.html) || [Nexus Link](https://www.nexusmods.com/oblivion/mods/15781?tab=description)

`TES4LODGen` will generate the relevant LOD file ahead of time. Apparently it
helps with performance in-game, but may result in slower initial load times when
starting the game.

### Setup

I downloaded the files from Nexus, and extracted the archive to
_OblivionMods/Tools/TES4LODGen_.

### Usage

Run the alias. The program should auto-find everything, do some magic, and will
eventually report that it has finished. At this point, you can close the
application. Here's the alias; replace directories accordingly:

```
alias oblivion-wyre='STEAM_COMPAT_DATA_PATH=/path/to/steam/directory/steamapps/compatdata/22330/ \
                     STEAM_COMPAT_CLIENT_INSTALL_PATH=/path/to/steam/directory/ \
                     /path/to/proton/proton run /path/to/OblivionMods/Tools/TES4LODGen/TES4LODGen.exe'
```

## BethINI


# Mod List

Every player's mod list is different. Some will focus on visuals, making the
game as graphically impressive and pretty as possible. Others care primarily
about additional content. I tend towards the later, with a preference for
additional survival or realism mods. I recommend starting with the "Core Mods"
section in the [Oblivion Comprehensive Modding Guide by
Dispensation](https://www.nexusmods.com/oblivion/mods/49898) which will cover
some essential performance and enhancement mods.

Below are some specific mods I would like to highlight, and which I enjoy.


## Survival Related

### Basic Primary Needs & Personal Hygiene

[Nexus Link - Basic Primary
Needs](https://www.nexusmods.com/oblivion/mods/37088)
[Nexus Link - Basic Personal
Hygiene](https://www.nexusmods.com/oblivion/mods/42038_)

These two mods cover most of the survival aspects of my mod pack. "Basic Primary
Needs" adds hunger, thirst, and fatigue, while "Basic Personal Hygiene" adds
cleanliness. Managing these will feel tedious to some, but I really like having
to eat and drink, and visiting a bath house after a long time adventuring.

Each mod can make use of [additional HUD Status
Bars](https://www.nexusmods.com/oblivion/mods/34905), which makes tracking the
new needs much easier.

### Traveler's Tent

[Nexus Link](https://www.nexusmods.com/oblivion/mods/49654)

This mod adds a portable player home, and is supremely comfy.


## World Enhancement

These I would consider my graphical improvements. I'm generally not too
concerned with making the game look good, but I love making the game feel more
realistic. These mods make Cyrodiil feel more alive.

### Better Cities

[Nexus Link](https://www.nexusmods.com/oblivion/mods/16513/)

This is a massive collection of city overhaul and enhancement mods. I was
awe-struck when I walked around the Imperial City for the first time with this
mod enabled. Bravil felt like a dangerous, crowded harbor town. Leyawin looks
like an actual place people live. Though the improvements do come with FPS hits.
Doubly-so if enabling the Open Cities option, which moves cities into the
overworld space, instead of their own individual instances. It's a balancing
act: the immersion of walking directly into a city sometimes isn't worth
crashing to desktop when adventuring around cities.

### COBL

[Nexus Link](https://www.nexusmods.com/oblivion/mods/21104)

"Common Oblivion" enriches the world of Oblivion by adding lots of little
things, and helping different mods "talk" to each other. I like to think of it
as filling in a lot of the details that couldn't be included initially.

### Enhanced Economy

[Nexus Link](https://www.nexusmods.com/oblivion/mods/25078) and [Lubrons
Patch](https://www.nexusmods.com/oblivion/mods/47184)

This mod and the corresponding patch make the economy of the world more dynamic.
What I really like are the merchant quests that are added. Several merchants in
each town will ask you to find an item in one of the nearby dungeons. It adds
flavor to the game in just the right way.

### Lights of Oblivion - Road Lanterns

[Nexus Link](https://www.nexusmods.com/oblivion/mods/46131)

A very simple mod that I feel really enhances my travel around Cyrodiil. I avoid
fast-traveling whenever possible, and walking lit roads at night feels comfy.

### Natural Environments

[Nexus Link](https://www.nexusmods.com/oblivion/mods/2536)


### Cyrodiil Travel Services

[AFK Mods
Link](https://www.afkmods.com/index.php?/files/file/263-cyrodiil-travel-services/)

I really enjoyed that in Skyrim there was a dude with a wagon you could pay to
travel to the various cities. This mod adds similar functionality, and then
some. Useful when playing the game without fast-travel enabled.


## Overhauls

Arguably, these are the heavy hitters. These mods will alter the mechanics of
the game, often making things more challenging but also more rewarding.

### Maskar's Oblivion Overhaul

### Vanilla Combat Enhanced

### Supreme Magicka
