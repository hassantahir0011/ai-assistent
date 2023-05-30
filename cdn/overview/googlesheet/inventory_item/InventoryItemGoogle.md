# Google Sheet InventoryItem 
Push all your inventory items  to Google Sheet.

## Overview
Google Sheet is an easy and efficient way to track your events in it. This is one time process to keep track on all the events need to get all details on your store.

## Prerequisites
You need a google account to create a Google Sheet. So first of all create a Gmail account and follow the installation process.

## Installation

1. First of all you need an account at https://google.com/ if you have then login or create new then go to https://docs.google.com/  
2. Select Sheet from left nav if you not have created.
3. Select Blank Sheet and save it with a name of your choice. [Here we need to provide a blank xlsx file with the headers in it for the sample]
4. Create a sheet with name **inventory_items**  to track all your inventory items  in it. 
5. The header row of the **inventory_items**  Google Sheet contains following Columns to track all inventory items  details: 

* ID 
* SKU
* Created At
* Updated At
* Required Shipping
* Cost
* Country Code Of Origin
* Province Code Of Origin
* Harmonized System Code
* Tracked
* Country Harmonized System Codes

6. Under Tools select Script editor
7. Copy the Script Code into the file and save the project with same name as the sheet name. Script File
8. Now click on Publish tab and click on Deploy as web app...
9. The deployement window appears select the values from the dropdowns as follows screen.
10. Copy the current web app URL and configure create events for your shop inventoryItems. 
11.	Now goto your Shopify Admin Panel click on Apps in the left nav then select Connectify and Setup webhooks for the apps. 
### Event triggers on: 
* inventory_items-create
* inventory_items-update
* inventory_items-delete
Create each events above to register the webhook. Make sure you enabled before you hit save button.

## Additional Resources
Introduction to Google Sheet Apps scripts. [Click Here](https://developers.google.com/apps-script/guides/sheets)

## Media

Here are media files for your reference   Choose from Channels
* Choose from Channels.
* Select Google_sheets and create each events for the app using the webhook url as showing in following the screen. Repeat the process for each events you want track.
