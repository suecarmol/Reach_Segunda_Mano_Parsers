#!/bin/bash

input="result_20150506-00-22_out.txt"

echo "recId|SeqNumber|seqLength|displayLatitude|displayLongitude|district|county|city|postalCode|state|country" >> mexico.txt 
while IFS='|' read -r f1 f2 f3 f4 f5 f6 f7 f8 f9 f10 f11
do
    if [ $f11 == "MEX" ]; then
        echo $f1"|"$f2"|"$f3"|"$f4"|"$f5"|"$f6"|"$f7"|"$f8"|"$f9"|"$f10"|"$f11 >> mexico.txt
    else
        echo $f1"|"$f2"|"$f3"|"$f4"|"$f5"|"$f6"|"$f7"|"$f8"|"$f9"|"$f10"|"$f11 >> others.txt
    fi
done < "$input"