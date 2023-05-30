Push all your Order transactions in single place to Google Sheet.
## Overview
Google Sheet is an easy and efficient way to track your events in it. This is one time process to keep track on all the events need to get all details on your store.
## Prerequisites
You need a google account to create a Google Sheet. So first of all create a Gmail account and follow the installation process.
## Installation
1.	First of all you need an account at https://google.com/ if you have then login or create new then go to https://docs.google.com/  
2.	Select Sheet from left nav if you not have created.
3.	Select Blank Sheet and save it with a name of your choice.
4.	Create a sheet with name **order_transactions** to track all your Order transactions in it. Please see the sheet for reference, click here
5.	The header row of the **order_transactions** Google Sheet contains following Columns to track all order transactions details: 
*	ID
*	Order ID
*	Kind
*	Gateway	Status
*	Message	
*	Created At
*	Test	
*	Authorization
*	Location ID
*	User ID 	
*	Parent ID	
*	Processed At	
*	Device ID	
*	Receipt	
*	Error Code	
*	Source Name 	
*	Amount	
*	Currency	
*	PD (credit_card_bin)	
*	PD (avs_result_code)	
*	PD(cvv_result_code)	
*	PD(credit_card_number)	
*	PD(credit_card_company)	

6.	Under Tools tab select Script editor
7.	Copy the Script Code into the file and save the project with same name as the Spreadsheet file name. Script File
8.	Now click on Publish tab and click on Deploy as web app...
9.	The deployement window appears select the values from the dropdowns as follows screen.
10.	 Copy the current web app URL and configure create events for your shop Order transactions. 
11.	 Now goto your shopify admin pannel click on Apps in the left nav then select Connectify and Setup webhooks for the apps. 
### Event triggers on: 
* order_transactions_create
Create event above to register the Google Sheet webhook. Make sure you Enable the event before you hit Save button.
## Additional Resources
Introduction to Google Sheet Apps scripts. Click Here
## Media
Here are media files for your reference   Choose from Channels
* Choose from Channels.
* Select Google_sheets and create each events for the app using the webhook url as showing in following the screen. 
