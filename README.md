# PHP-CSV-Reading
PHP application that loads in a CSV file and sorts data into lists to avoid overlapping times.


Operation:

To operate the application, locate the line:

		$csvData = getArrayOfData('data/dataSet.csv');


It should be located just underneath the opening <body> tag. Place the data set in the data folder on the server. Replace dataSet.csv with the name of your data set, followed by .csv

Then refresh the web page and the new sorted lists should be displayed




Assumptions:

- The operating hours for the property managers are Mon - Sun, 9am  - 6:30pm

- Time slots are, at minimum, 2 hours apart. 1hr 30mins for the check-in, and 30mins travel time to the next property

- Lunch breaks are not calculated for this version

- It is not expected that every check-in would take the full time

- 9am is the earliest timeslot

- 5pm is the latest time-slot

- Fresher's week begins September 15th 2020

- Thus the time to check all 30 properties is between 15th August 2020 - 14th September 2020

- Multiple tenants moving in to the same property must be there at the same date and time for check-in

- As the CSV file was made by manualy inputting data, the date and times are in chronological order
