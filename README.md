##Php code workflow

For the last few months, I've been working on a SPA project written in Symfony2 on the server and Angular on the client. Most of the code revolves on calling a controller
from the browser. The controller then fetches the data from the database and returns it to the client. I tried to make it uniformed with 
some design patterns, but different data sent from the client had to be processed with different design patterns. Some were uniformed and easy
to read but some were messy and hard to read. So I decided to create a workflow design pattern that will be the same for every code execution.

I got the idea from ASP.NET world, mainly Microsoft Workflow Foundation. By no means is this project anything even remotly similar to Workflow
Foundation but it made me think. Why not make something similar for Php? Most of you will think this is totally unnecessary + overkill. I actually
agree. With this design pattern, there is a lot more code to be written but there are some benefits.

For example, Code Workflow checks for returns types of methods that you want to execute, so when some method does not return the desired type,
error is thrown. But that could also be an overkill since PHP is not designed to be a strongly types programming language. All thing aside, this 
could be the most pointless project ever created but after I started working on it, I became stuborn and had to make it work. Someone might like it,
most of you will hate it. That is the way of the samurai :).

Everything will be clear from the examples below, so continue reading.

The example object are in src/Demo directory.

####The basic way

In the examples in src/Demo directory, you can find the Company and Person object. Basic way of using these object would be like this...
 
 ```
 $company = new Company();
 $company->setCompanyName(new String('Shady Kaymans Company'));
 
 $john = new Person(new Unique());
 $john->setName(new String('John'))
 $john->setLastname(new String('Doe'))
 $john->setAge(new Integer(28));
 
 $company->hireEmployee($john);
 
 $john->foundJob($company);
 ```
 
 And this is just fine. It's readable and maintable. But what happens when you have to fetch company data from the database based on some JSON
 data sent by the client? What happens when you have to create a Factory that creates Person object based on database data? Even with pristine
 usage of design patterns, this code could become unreadable. 
 
 With Code workflow, the same code above could be rewritten to this code...
 
 ```
 $company = new Company();
 $john = new Person(new Unique());
 
$compiler
    ->runObject($company)
    ->withMethods(
        $compiler->method()->name('setCompanyName')->withParameters(new String('Shady Kaymans Company'))->void()->save()
    )
    ->runObject($john)
    ->withMethods(
        $compiler->method()->name('setName')->withParameters(new String('John'))->void()->save(),
        $compiler->method()->name('setLastname')->withParameters(new String('Doe'))->void()->save(),
        $compiler->method()->name('setAge')->withParameters(new Integer(28))->void()->save()
    )
    ->then()
    ->runObject($company)
    ->withMethods(
        $compiler->method()->name('hireEmployee')->withParameters($john)->void()->save()
    )
    ->then()
    ->runObject($john)
    ->withMethods(
        $compiler->method()->name('foundJob')->withParameters(new Job($company))->void()->save()
    )
    ->compile();
 ```
 
 This is the same code executed but with human readable code. This could be read as follows:
 
 ```
 Run the object $company with method 'setCompanyName' that doesn't return anything. 
 Then, run object john with methods 'setName', 'setLastname' and 'setAge' with the 
 desired parameters and void method return. Then, run the object $company 
 again with method 'hireEmployee' with $john object as a parameter.  
 Then, run object $john again with method 'foundJob' that accepts  
 Job object and returns void. Compile the entire code. 
 ```
 
 ##**NOTE
 
 ```
 If you have multiple 'set' methods in an object, 
 you can execute the above code like this...
 
 ->runObject($john)
     ->withMethods(array(
        'setName' => new String('John'),
        'setLastname' => new String('Doe'),
        'setAge' => new Integer(28)
     ))
 
 Compiler::withMethods() here accepts an array 
 with the method name as key and method parameters as value
 ```
 
 What happens when you wish to view the returned value of a method? That is also possible...
 
 ```
 $compiler
     ->runObject($company)
     ->withMethods(
         $compiler->method()->name('setCompanyName')->withParameters(new String('Shady Kaymans Company'))->void()->save(),
         $compiler->method()->name('getCompanyName')->string()->save()
     )
     ->ifMethod('getCompanyName')->fails()->thenRun(function() {
        return 'getCompanyName failed to return a string';
     })
     ->ifMethod('getCompanyName')->succedes()->thenRun(function(){
        return 'success';
     })
     ->compile()
     
     $response = $compiler->runResponseFor($company, 'getCompanyName');
     
     // if successfull, prints 'success', if not then prints 'getCompanyName failed to return a string'
     var_dump($response);
 ```
 
 




