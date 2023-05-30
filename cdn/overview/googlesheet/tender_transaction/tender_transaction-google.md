# Google Sheet TenderTransaction

Push all your TenderTransaction data to Google Sheet.

## Overview
Google Sheet is an easy and efficient way to track your events in it. This is one time process to keep track on all the events need to get all details on your store.

## Prerequisites
You need a google account to create a Google Sheet. So first of all create a Gmail account and follow the installation process.

## Installation

1. First of all you need an account at https://google.com/ if you have then login or create new then go to https://docs.google.com/  
2. Select Sheet from left nav if you not have created.
3. Select Blank Sheet and save it with a name of your choice. [Here we need to provide a blank xlsx file with the headers in it for the sample]
4. Create a sheet with name **tender_transactions** to track all your tender_transactions in it. 
5. The header row of the **tender_transactions** Google Sheet contains following Columns to track all **tender_transactions** details: 

* ID
* Order ID
* Amount
* Currency
* User Id
* Test
* Processed At
* Remote Reference
* Credit Card Number
* Credit Card Company
* Payment Method

6. Under Tools select Script editor
7. Copy the Script Code into the file and save the project with same name as the sheet name. Script File
8. Now click on Publish tab and click on Deploy as web app...
9. The deployment window appears select the values from the drop-downs as follows screen.
10. Copy the current web app URL and configure create events for your shop . 
11. Now go to your Shopify admin panel click on Apps in the left nav then select Connectify and Setup webhooks for the apps. 
#### Event triggers on: 
* tender_transactions-create

Create each events above to register the webhook. Make sure you enabled before you hit save button.

## Additional Resources
Introduction to Google Sheet Apps scripts. [Click Here](https://developers.google.com/apps-script/guides/sheets)

## Media

Here are media files for your reference   Choose from Channels
*	Choose from Channels.
*	Select Google_sheets and create each events for the app using the webhook url as showing in following the screen. Repeat the process for each events you want track.