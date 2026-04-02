# ✨ VibrantVisuals

> A lightweight **PocketMine-MP 5** plugin that restores access to Minecraft Bedrock’s **Vibrant Visuals** graphics mode.

---

## 🔍 Overview

By default, **PocketMine-MP** disables Vibrant Visuals for all players during login using a hardcoded flag in the resource pack handshake.

**VibrantVisuals** removes that restriction.

It intercepts the outgoing packet and safely overrides the flag, allowing supported players to enable Vibrant Visuals — just like on official servers.

> ⚡ No config. No commands. Plug-and-play.

---

## ✅ Requirements

- PocketMine-MP 5.x  
- Minecraft Bedrock **1.21.120+**  
- A device that supports Vibrant Visuals  

---

## 📦 Installation

1. Download or build the `.phar`
2. Place it in your server’s `plugins/` folder  
3. Restart your server  

That’s it — you’re done.

---

## 🚀 Usage

The plugin works automatically after installation.

Players can enable Vibrant Visuals themselves:

**Settings → Video → Graphics Mode → Vibrant Visuals**

- ✔ Supported players → Can enable it normally  
- ✔ Unsupported players → No changes, no issues  

---

## ⚙️ How It Works

During login, PocketMine-MP sends a `ResourcePacksInfoPacket` with:

```php
forceDisableVibrantVisuals = true;
```

This plugin:

- Listens to `DataPacketSendEvent`
- Detects the packet
- Uses Reflection to override the flag before it reaches the client

```php
public function onDataPacketSend(DataPacketSendEvent $event): void {
    foreach ($event->getPackets() as $packet) {
        if ($packet instanceof ResourcePacksInfoPacket) {
            $ref = new \ReflectionProperty($packet, 'forceDisableVibrantVisuals');
            $ref->setAccessible(true);
            $ref->setValue($packet, false);
        }
    }
}
```

> ⚠️ **Why Reflection?**  
> PocketMine-MP currently does not expose a public API for this flag.

An official fix is being tracked here:  
👉 https://github.com/pmmp/PocketMine-MP/issues/6739  

This plugin will switch to the official API once available.

---

## ❓ FAQ

**Does this affect players without support?**  
No — unsupported players continue using their default graphics.

**Does this impact performance?**  
No — the check runs once during login and is negligible.

**Why don’t I see the option?**  
Make sure:
- You’re on **1.21.120+**
- Your device supports it
- You enabled it manually in settings

---

## 💡 Features

- Zero configuration  
- Fully automatic  
- Safe fallback for unsupported clients  
- Minimal performance impact  
- Clean and focused implementation  

---

## 📄 License

MIT License
