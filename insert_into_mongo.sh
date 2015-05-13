#!/bin/bash

#script that inserts documents on mongodb database 
#INSTRUCTIONS: run script with one parameter: 
#this parameter indicates which type of document you want to insert
#(states, municipalities, zip codes or suburbs)
#NOTE: you will need to name the folders according to the types of documents in order for this to work.


FILES=$1_documents/*
for f in $FILES
do
  echo "Processing $f file..."
  # take action on each file. $f store current file name
  
  mongoimport --db segundamano --collection reach --file $f 

done
