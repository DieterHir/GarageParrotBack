<?php

if(isset($_POST['submit'])){
    if(isset($_POST['VehiculeTitle']) && isset($_POST['VehiculePrice']) && isset($_POST['VehiculeYear']) && isset($_POST['VehiculeMileage']) && isset($_POST['VehiculeCaracs']) && isset($_POST['VehiculeEquipments'])){
        if(!empty($_POST['VehiculeTitle']) && !empty($_POST['VehiculePrice']) && !empty($_POST['VehiculeYear']) && !empty($_POST['VehiculeMileage']) && !empty($_POST['VehiculeCaracs']) && !empty($_POST['VehiculeEquipments'])){
            $title=htmlspecialchars($_POST['VehiculeTitle']);
            $price=htmlspecialchars($_POST['VehiculePrice']);
            $year=htmlspecialchars($_POST['VehiculeYear']);
            $mileage=htmlspecialchars($_POST['VehiculeMileage']);
            $caracs=htmlspecialchars($_POST['VehiculeCaracs']);
            $equipments=htmlspecialchars($_POST['VehiculeEquipments']);

            echo "L'article $title au prix de $price, année de fabrication $year avec $mileage kms au compteur. $caracs & $equipments inclus.";
        }
    }
}

?>