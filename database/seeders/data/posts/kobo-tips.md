## Display cover instead fnac logo

Connect your Kobo to your computer and navigate to Kobo disk to find this `.kobo/affiliate.conf`

![Where to find affiliate.conf](IMAGE/kobo-tips/affiliate.webp)

Replace `fnac` by `Kobo`

```diff[.kobo/affiliate.conf]
[General]
- affiliate=fnac
+ affiliate=Kobo
```

## Energy saving

Go to **More->Settings->Energy saving and privacy**

![Options to keep battery on Kobo](IMAGE/kobo-tips/energy-saving-and-privacy.webp)

- **Automatically go to sleep after** & **Automatically power off after** keep your battery safe.
- **Show current read**, **Show book covers full screen**, **Show info panel on full screen covers** & **Indicator light while charging** is only useful for aesthetic.

## Sources

- [**blog.slucas.fr**](https://blog.slucas.fr/blog/kobo-ereader-touch-5)
- [**epubor.com**](https://www.epubor.com/kobo-tips-and-tricks-you-must-know.html)
