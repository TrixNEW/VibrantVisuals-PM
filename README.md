✨ VibrantVisuals
> A lightweight PocketMine-MP 5 plugin that removes the server-side block on Minecraft Bedrock's Vibrant Visuals graphics mode.
---
🔍 About
By default, PocketMine-MP forcefully disables Vibrant Visuals for every player who connects to your server via a hardcoded flag in the resource pack handshake. This plugin intercepts that packet and flips the flag off, allowing eligible players to use Vibrant Visuals just as they would on an official server. No configuration. No commands. Just install and go.
---
✅ Requirements
> PocketMine-MP 5.x
> Players must be on Minecraft Bedrock 1.21.120 or later
> Players must have a compatible device
---
📦 Installation
> Download or build the plugin `.phar`
> Place it in your server's `plugins/` folder
> Restart the server
> That's it.
---
🚀 Usage
Once installed, the server-side block is automatically removed for all connecting players. Players who wish to use Vibrant Visuals still need to enable it themselves:
Settings → Video → Graphics Mode → Vibrant Visuals
Players on unsupported devices or older versions will simply continue using their current graphics mode — nothing will break for them.
---
⚙️ How It Works
PocketMine-MP sends a `ResourcePacksInfoPacket` during the login sequence with `forceDisableVibrantVisuals` hardcoded to `true`. This plugin listens for that packet via `DataPacketSendEvent` and uses PHP Reflection to set the value to `false` before it reaches the client.
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
> **Note:** This approach uses Reflection as a workaround because PocketMine-MP does not yet expose an official API for this. An official fix is tracked at [pmmp/PocketMine-MP#6739](https://github.com/pmmp/PocketMine-MP/issues/6739). Once merged, this plugin will be updated to use the proper API.
---
❓ FAQ
Does this affect players without Vibrant Visuals support?
No. Players on unsupported devices or older versions are unaffected.
Does this impact server performance?
Negligibly. The packet check runs only once per player during login.
Why isn't Vibrant Visuals showing up for my players?
Make sure players are on Minecraft 1.21.120+ and have manually enabled it in their video settings.
---
📄 License
MIT
