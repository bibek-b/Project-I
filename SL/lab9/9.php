<?php
//6.
    // class Person{
    //     public $name;
    // }

    // class Employee extends Person{
    //     public $salary,$position;
        
    //     function setDetails($name,$salary,$position){
    //         $this->name = $name;
    //         $this->salary = $salary;
    //         $this->position = $position;
    //     }

    //     function displayDetails(){
    //         echo "Employee Name: ". $this->name ."</br>";
    //         echo "Employee Salary: ". $this->salary ."</br>";
    //         echo "Employee Position: ". $this->position ."</br>";
    //     }
    // }

    // $obj = new Employee();
    // $obj->setDetails("Bibek",500000,'Web Developer');
    // $obj->displayDetails();

    //7.
    // abstract class Animal{

    //      abstract public function eat();

    //    abstract public function makeSound();
    // }

    // class Dog extends Animal{
    //     function eat(){
    //         echo "Dog is eating Meat. <br>";
    //     }
    //     function makeSound()
    //     {
    //         echo "Bhaow Bhaow <br> <br>" ; 
    //     }
            
    // }

    // class Cat extends Animal{
    //     function eat(){
    //         echo "Cat is eating Fish.<br>";
    //     }
    //     function makeSound()
    //     {
    //         echo "Meow Meow <br><br>" ; 
    //     }
            
    // }

    // class Bird extends Animal{
    //     function eat(){
    //         echo "Bird is eating Berries.<br>";
    //     }
    //     function makeSound()
    //     {
    //         echo "chirps" ; 
    //     }
            
    // }

    // $DogObj = new Dog();
    // $DogObj->eat();
    // $DogObj->makeSound();

    // $CatObj = new Cat();
    // $CatObj->eat();
    // $CatObj->makeSound();

    // $BirdObj = new Bird();
    // $BirdObj->eat();
    // $BirdObj->makeSound();

    //8.
    // class Shape{
    //     public $length,$breadth;
        
    //    public function getArea($length,$breadth){}
    //    public function getPerimeter($length,$breadth){}

    // }
    // class Rectangle extends Shape{
    //     public function getArea($length, $breadth)
    //     {
    //         echo "Area of Rectangle: ".$length * $breadth;
    //     }
    //     public function getPerimeter($length, $breadth){}
    // }

    // $obj = new Rectangle();
    // $obj->getArea(5,9);

    //9.

    interface Shape{
        public function Area();
        public function Perimeter();
    }

    class Rectangle implements Shape{
        function Area()
        {
            echo "This is Area from Rectangle.<br>";
        }

        function Perimeter()
        {
            echo "This is Perimeter from Rectangle.<br><br>";
        }
    }

    class Square implements Shape{
        function Area()
        {
            echo "This is Area from Square.<br>";
        }

        function Perimeter()
        {
            echo "This is Perimeter from Square.";
        }
    }

    $r = new Rectangle();
    $r->Area();
    $r->Perimeter();

    $s = new Square();
    $s->Area();
    $s->Perimeter();
?>