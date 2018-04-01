#!/bin/bash
sudo cp -r ./stb-plymouth-theme /usr/share/plymouth/themes/
sudo update-alternatives --install /usr/share/plymouth/themes/default.plymouth default.plymouth /usr/share/plymouth/themes/stb-plymouth-theme/stb-plymouth-theme.plymouth  100
sudo update-initramfs -u
echo "FRAMEBUFFER=y" | sudo tee -a /etc/initramfs-tools/conf.d/splash && sudo update-initramfs -u -k all 
