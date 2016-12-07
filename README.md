# Iphone Sensors

*...a skeleton README...*

*Iphone Sensors* is a solution for all you tinkerers out there who want to have a play with the Azure IoT suite but don't have a RaspberryPi or an Arduino or don't want to simulate sensor data. All you need is an Iphone (packed with sensors) and a Microsoft Azure Subscription (you can get a trial one from https://azure.microsoft.com/en-us/free/). 

## Getting started
0. Install Device Explorer. A pre-built version of the Device Explorer application for Windows can be downloaded by clicking on this link: Downloads (Scroll down for SetupDeviceExplorer.msi). The default installation directory for this application is "C:\Program Files (x86)\Microsoft\DeviceExplorer". You might want to pin the DeviceExplorer.exe application to the taskbar for easier access.
1. Install an Iphone app called SensorLog
2. Provision a php Web App with the code from the *1. Web App* folder. The App will do the protocol translation from SensorLog HTTP GET/PUSH of csv data to an IoT or Event Hub REST call, essentially becoming a simple IoT Cloud Gateway
3. Write down the URL of your Web App and update SensorLog settings
4. Decide whether you'd like to use the Azure IoT Hub or Event Hub
5. Provision the above
5.5. If using the Azure IoT Hub, create your device using Device Explorer and copy the connection strings
6. Update the php code with the connection strings
7. Create an Azure Stream Analytics Job, define your IoT Hub or Event Hub as the input, name it [input], JSON format
8. Create at least one output, name it [output-powerbi] and authorise it with Power BI
9. Use the sql sample in the *2. Azure Stream Analytics* folder. The code has a few more output samples that have been commented out:
	- SQL DB
	- Blob Storage
	- DocumentDB
	- Service Bus Topic for consumption by Notification Hub (to sending out push notifications when the device orientation changes, e.g. Landscape to Portrait)
	- Azure Table Storage
10. Fire up the Iphone app and the Stream Analytics Job. Once the first message comes through the ASA, a new data source will show up in Power BI which you can start start building live dashboards against, for more info refer to https://powerbi.microsoft.com/en-us/blog/outputting-real-time-stream-analytics-data-to-a-power-bi-dashboard/

## Architecture
<img src="https://raw.githubusercontent.com/iizotov/Iphone-sensors/master/architecture.png">

## Additional Reading
Reference Architecture: https://azure.microsoft.com/en-us/updates/microsoft-azure-iot-reference-architecture-available/