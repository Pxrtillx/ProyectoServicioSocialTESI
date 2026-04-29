<style>
        /* Paleta de colores */
        :root {
            --rojo-edomex: #982233; /* Color guinda/rojo oficial */
            --oro-edomex: #b38e5d;  /* Dorado institucional */
            --gris-claro: #f4f4f4;
            --texto-oscuro: #4d4d4d;
        }

        body {
            font-family: 'Montserrat', sans-serif, Arial;
            background-color: var(--gris-claro);
            margin: 0;
            padding: 0;
            color: var(--texto-oscuro);
        }

        /* Barra superior estilo Gob */
        .header-gob {
            background-color: var(--rojo-edomex);
            height: 5px;
            width: 100%;
        }

        header {
            background-color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        h1 {
            color: var(--rojo-edomex);
            font-size: 1.6rem;
            margin: 0;
            font-weight: 700;
        }

        h3 {
            color: var(--oro-edomex);
            margin: 5px 0;
            font-weight: 400;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        /* Contenedor principal */
        .container {
            max-width: 650px;
            background: white;
            margin: 40px auto;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-top: 4px solid var(--rojo-edomex);
        }

        /* Estilo de las filas de información */
        .info-row {
            margin-bottom: 20px;
            display: flex;
            align-items: baseline;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .label-title {
            font-weight: bold;
            color: var(--rojo-edomex);
            min-width: 250px;
            font-size: 0.9rem;
        }

        .data-value {
            color: #333;
            flex-grow: 1;
        }

        /* Sección de enlace / Botón */
        .registro-container {
            margin-top: 40px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #eee;
            text-align: center;
        }

        .registro-container p {
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .btn-upload {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--rojo-edomex);
            color: white;
            text-decoration: none;
            border-radius: 2px;
            font-weight: bold;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .btn-upload:hover {
            background-color: #7a1b29;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        footer {
            text-align: center;
            font-size: 0.8rem;
            color: #999;
            margin-top: 20px;
            padding-bottom: 20px;
        }
        /*Formulario de Carga*/
        .upload-box{
            border: 2px dashed var(--oro-edomex);
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            background-color: #fcfaf7;
            transition: all 0.3 ease;
        }

        .upload-box-hover{
            border-color: var(--rojo-edomex);
            background-color: #f9f4ee;            
        }

        .file-input{
            margin: 20px 0;
            display: block;
            width: 100%;
        }

        .btn-enviar{
            background-color: var(--rojo-edomex);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s;
        }

        .btn-enviar:hover{
            background-color: #7a1b29;
            transform: translateY(-1px);
        }

        .instrucciones{
            font-size: 0.9rem;
            color: var(--texto-oscuro);
            margin-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">