# U of U PARKING SYSTEM

**Note:  This is a project repo for a group project for IS6465 at the University of Utah.  It is NOT a real, functioning parking lot management system.  It is written by student programmers for a group project and is only here so we could collaborate.  Do not use for any other purpose!!**

It is the University of Utah’s vision to provide for its students an effective parking system that accommodates the needs for each student. The school needs a way to monitor, manage, and track parking usage around campus. The goal is to ensure that only those with the passes are allowed to use the parking stalls. The system allows the administrators to monitor parking usage in real time, and track parking availability throughout the day and even accommodate for the event parking. 

You are to design a system to keep track of various parking usecases for the University of Utah. The University of Utah sells parking permits to drivers. A driver is identified by driver id, firstname, lastname, address and type. There are different types of drivers and a driver must be either student, faculty, or guest, but may not be more than one at the same time. Each driver is identified by the driver id. Each driver has to have at least one vehicle and may have more than one vehicle. Each vehicle has only one driver. Vehicle is identified by vehicle id, license plate number, make of vehicle, model, color, year, and driver id. Each vehicle may not have any violation, or may have many violations. Each violation is assigned to only one vehicle. 

Violation is identified by violation id, date issued, violation type, and needs a vehicle id. Every violation must have at least one violation type but can have many. Each violation type is tied to violation. Violation type is identified by violation_type_id, violation name, and amount due. Each vehicle does not have to have a permit, but can have more than one permit. Each permit must be assigned to a vehicle. Permit is identified by permit id, permit type, purchase date, expiration date. Each permit is valid for at least one parking lot, but may have more than one parking lot. Parking lot is identified by lot id, permit type, address, and capacity. A parking lot consists of one or more parking spaces. A parking space has to be assigned to a parking lot. Parking space is identified by a space id, parking space type, arrival time, and depart time. There is a parking space type for each parking space and each type is identified by parking space type id.

## Driver Use Cases:

View/update/add personal info\
View/update/add/delete vehicle info\
View/add permit\


## Administrator Use Cases:

View a list of drivers and their vehicles\
View/update/add/delete drivers\
View/update/add/delete vehicles\
View/update/add/delete permits\

## Generate reports:

List of drivers \

