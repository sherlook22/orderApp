<?php

namespace App\Components;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendPedido {



    public $correo;

    public function __construct(PHPMailer $correo){
        $this->correo = $correo;
    }

    public function enviar($data) {

        $ped = '';

        foreach ($data['pedido'] as $value) {
            $ped .=  '<tr><td style="
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            ">'.$value->title_name.'</td>
            <td style="
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            ">'.$value->edition_num.'</td>
            <td style="
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px;
            ">'.$value->cant_pedida.'</td></tr>';
        }

       $this->correo->Subject = "Pedio vendedor " . $data['vendedor']; //setSubject($con);
       $this->correo->Body = '
       <div style="
        background-color: #dfe6e9; 
        width: 35em;
        height: auto;
        margin: left;
        border: 1px solid black;
        font-size: 20px;
        font-family: sans-serif;
        box-shadow: 5px 5px 5px black;
        ">
        <div style="
        padding: 5px;
        margin: 5px;
        border: 1px solid black;
        display: inline-block;
        ">
            <h3 style="margin: 0px;">Pedido Vendedor <strong>'.$data['vendedor'].'</strong></h3>
            <h5 style="margin: 0px;">Nombre: '.$data['nombre'].'</h5>
            <h5 style="margin: 0px;">apellido: '.$data['apellido'].'</h5>
        </div>
        <div style="
        padding: 5px;
        display: inline-block;
        ">
        <table style="
        border: 1px solid black;
        border-collapse: collapse;
        width: 30em;
        ">
            <tr">
                <th style="
                border: 1px solid black;
                border-collapse: collapse;
                text-align: left;
                padding: 3px;
                "
                >Titulo</th>
                <th style="
                border: 1px solid black;
                border-collapse: collapse;
                text-align: left;
                padding: 3px;
                ">Edicion</th>
                <th style="
                border: 1px solid black;
                border-collapse: collapse;
                text-align: left;
                padding: 3px;
                ">Cantidad</th>
            </tr>
            
            '.$ped.'

        </table>

        <div>
            <p>
                Saludos, Gonzalo Re. <br>
                <strong>Domingo Juan Taleti S.A.</strong> 
            </p>
        </div>

        </div>
    
    </div>';



        try{

            $this->correo->send();
            return true;
        } catch(Exception $e) {
            return false;
        }

    }

}
