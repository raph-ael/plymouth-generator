# Staufenbiel Plymouth Theme

## Installation

```
git clone gitlab@git.staufenbiel.de:web-development/stb-plymouth-theme.git
sudo cp -r ./stb-plymouth-theme /usr/share/plymouth/themes/
sudo update-alternatives --install /usr/share/plymouth/themes/default.plymouth default.plymouth /usr/share/p$
sudo update-initramfs -u
echo "FRAMEBUFFER=y" | sudo tee -a /etc/initramfs-tools/conf.d/splash && sudo update-initramfs -u -k all 
```
