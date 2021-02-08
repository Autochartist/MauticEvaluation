# Mautic Evaluation
Files that offer some example code for certain Mautic features.
Note that this code does not necessarily include all error checking - it was created during Mautic evaluation
Documentation for Mautic API here: https://developer.mautic.org/

## To run code samples
1. Install composer (https://getcomposer.org/download/) in the root directory of the project
2. Install required Mautic library: composer require mautic/api-library
3. Prerequisite: 
   1. enable API on Mautic
   2. enabled BASIC AUTH on Mautic

## Dynamic Fields (/DynamicField/)
Code to create dynamic fields in Mautic
Available types are:
Boolean
Date
Date/Time
Email
List - Country
Locale
Lookup
Number
Phone
Region
Select
Select - Multiple
Text
Textarea
Time
Timezone
URL