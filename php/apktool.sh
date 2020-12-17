#!/bin/bash
prog="$0"
while [ -h "${prog}" ]; do
    newProg=`/bin/ls -ld "${prog}"`
    newProg=`expr "${newProg}" : ".* -> \(.*\)$"`
    if expr "x${newProg}" : 'x/' >/dev/null; then
        prog="${newProg}"
    else
        progdir=`dirname "${prog}"`
        prog="${progdir}/${newProg}"
    fi
done
oldwd=`pwd`
progdir=`dirname "${prog}"`
cd "${progdir}"
progdir=`pwd`
prog="${progdir}"/`basename "${prog}"`
cd "${oldwd}"
jarfile=apktool.jar
libdir="$progdir"
if [ ! -r "$libdir/$jarfile" ]
then
    echo `basename "$prog"`": can't find $jarfile"
    exit 1
fi
javaOpts=""
javaOpts="-Xmx512M -Dfile.encoding=utf-8"
while expr "x$1" : 'x-J' >/dev/null; do
    opt=`expr "$1" : '-J\(.*\)'`
    javaOpts="${javaOpts} -${opt}"
    shift
done
if [ "$OSTYPE" = "cygwin" ] ; then
	jarpath=`cygpath -w  "$libdir/$jarfile"`
else
	jarpath="$libdir/$jarfile"
fi
PATH=$PATH:`pwd`;
export PATH;
exec java $javaOpts -jar "$jarpath" "$@"
