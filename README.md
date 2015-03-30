##Php code workflow

For the last few months, I've been working on a SPA project written in Symfony2. Most of the code revolves on calling a controller
from the browser. The controller then fetches the data from the database and returns it to the client. I tried to make it uniformed with 
some design patterns, but different data sent from the client had to be processed with different design patterns. Some were uniformed and easy
to read but some were messy and hard to read. So I decided to create a workflow design pattern that will be the same for every code execution.

I got the idea from ASP.NET world, mainly Microsoft Workflow Foundation. By no means is this project anything even remotly similar to Workflow
Foundation but it made me think. Why not make something similar for Php?

Everything will be clear from the examples below, so continue reading.




