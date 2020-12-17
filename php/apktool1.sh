#!/bin/bash
user=$1 &&
pass=$2 &&
clear &&
echo -e "\033[0;32m\n\nVendedor: $user \n\033[0m" &&
echo -e "\033[0;32m\nPre-Configuração\n\033[0m" &&
chmod 777 /var/www/php/apktool.sh &&
mkdir -p /var/www/html/uploads/files/outros/apk/vpn/revenda &&
rm -r -f /var/www/html/uploads/files/outros/apk/vpn/revenda_temp$user &&
rm -f /var/www/html/uploads/files/outros/apk/vpn/revenda/$user.apk &&
touch /var/www/html/uploads/files/outros/apk/vpn/revenda/$user.wait &&
echo -e "\033[0;32m\nDescompilando\n\033[0m" &&
bash /var/www/php/apktool.sh d /var/www/html/uploads/files/outros/apk/vpn/hkhvpn.apk -o /var/www/html/uploads/files/outros/apk/vpn/revenda_temp$user &&
echo -e "\033[0;32m\nMudando icones se disponivel\033[0m" &&
if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-icon.jpg" ]; then
  echo -e "\033[0;32mNovo icone disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/main_icon.png' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-icon.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/main_icon.jpg'
fi
if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-icon.png" ]; then
  echo -e "\033[0;32mNovo icone disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/main_icon.png' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-icon.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/main_icon.jpg'
fi

if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-back.jpg" ]; then
  echo -e "\033[0;32mNovo backgroung disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-hdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-mdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xhdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xxxhdpi-v4/wall.png' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-hdpi-v4/wall.jpg' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-mdpi-v4/wall.jpg' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xhdpi-v4/wall.jpg' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xxxhdpi-v4/wall.jpg'
fi
if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-back.png" ]; then
  echo -e "\033[0;32mNovo backgroung disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-hdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-mdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xhdpi-v4/wall.png' &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xxxhdpi-v4/wall.png' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-hdpi-v4/wall.jpg' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-mdpi-v4/wall.jpg' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xhdpi-v4/wall.jpg' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-back.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable-xxxhdpi-v4/wall.jpg'
fi

if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-load.jpg" ]; then
  echo -e "\033[0;32mNovo loading screen disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/load_normal.jpg' &&
  cp '/var/www/html/uploads/files/outros/app_revenda/'$user'-load.jpg' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/load_normal.jpg'
fi
if [ -f "/var/www/html/uploads/files/outros/app_revenda/$user-load.png" ]; then
  echo -e "\033[0;32mNovo loading screen disponivel\033[0m" &&
  rm '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/load_normal.jpg' &&
  convert '/var/www/html/uploads/files/outros/app_revenda/'$user'-load.png' '/var/www/html/uploads/files/outros/apk/vpn/revenda_temp'$user'/res/drawable/load_normal.jpg'
fi
echo -e "\033[0;32m\nMudando vendedor\n\033[0m" &&
sed -i 's/>1</>'$user'</' /var/www/html/uploads/files/outros/apk/vpn/revenda_temp$user/res/values/strings.xml &&
echo -e "\033[0;32m\nRecompilando\n\033[0m" &&
bash /var/www/php/apktool.sh b /var/www/html/uploads/files/outros/apk/vpn/revenda_temp$user -o /var/www/html/uploads/files/outros/apk/vpn/revenda/$user.apk &&
echo -e "\033[0;32m\nReassinando\n\033[0m" &&
jarsigner -keystore /var/www/php/0.keystore -storepass $pass -keypass $pass /var/www/html/uploads/files/outros/apk/vpn/revenda/$user.apk hkhvpn_normal &&
echo -e "\033[0;32m\nLimpando arquivos temporarios\n\033[0m" &&
rm -r -f /var/www/html/uploads/files/outros/apk/vpn/revenda_temp$user &&
rm -f /var/www/html/uploads/files/outros/apk/vpn/revenda/$user.wait
