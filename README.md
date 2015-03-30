##Php code workflow

For the last few months, I've been working on a SPA project written in Symfony2 on the server and Angular on the client. Most of the code revolves on calling a controller
from the browser. The controller then fetches the data from the database and returns it to the client. I tried to make it uniformed with 
some design patterns, but different data sent from the client had to be processed with different design patterns. Some were uniformed and easy
to read but some were messy and hard to read. So I decided to create a workflow design pattern that will be the same for every code execution.

I got the idea from ASP.NET world, mainly Microsoft Workflow Foundation. By no means is this project anything even remotly similar to Workflow
Foundation but it made me think. Why not make something similar for Php?

Everything will be clear from the examples below, so continue reading.

The example object are in src/Demo directory.

####The basic way

In the examples in src/Demo directory, you can find the Company and Person object. Basic way of using these object would be like this...
 
 ```
 $company = new Company();
 $company->setCompanyName(new String('Shady Kaymans Company'));
 
 $john = new Person(new Unique());
 $john->setName(new String('Mario'))
 $john->setLastname(new String('Škrlec'))
 $john->setAge(new Integer(28));
 ```




