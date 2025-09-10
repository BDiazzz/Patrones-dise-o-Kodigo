<?php
// Interfaz Estrategia
interface EstrategiaSalida {
    public function mostrar(string $mensaje): void;
}

// Estrategia 1: Mostrar en consola
class SalidaConsola implements EstrategiaSalida {
    public function mostrar(string $mensaje): void {
        echo "Consola: " . $mensaje . PHP_EOL;
    }
}

// Estrategia 2: Mostrar en JSON
class SalidaJson implements EstrategiaSalida {
    public function mostrar(string $mensaje): void {
        echo json_encode(["mensaje" => $mensaje], JSON_PRETTY_PRINT) . PHP_EOL;
    }
}

// Estrategia 3: Guardar en archivo TXT
class SalidaTxt implements EstrategiaSalida {
    private $nombreArchivo;

    public function __construct($nombreArchivo = "salida.txt") {
        $this->nombreArchivo = $nombreArchivo;
    }

    public function mostrar(string $mensaje): void {
        file_put_contents($this->nombreArchivo, $mensaje . PHP_EOL, FILE_APPEND);
        echo "Mensaje guardado en {$this->nombreArchivo}" . PHP_EOL;
    }
}

// Contexto que usa la estrategia
class ContextoMensaje {
    private $estrategia;

    public function __construct(EstrategiaSalida $estrategia) {
        $this->estrategia = $estrategia;
    }

    public function setEstrategia(EstrategiaSalida $estrategia): void {
        $this->estrategia = $estrategia;
    }

    public function mostrarMensaje(string $mensaje): void {
        $this->estrategia->mostrar($mensaje);
    }
}

// -------- Uso --------
$mensaje = "Hola, este es un mensaje con el patrón Strategy";

// Mostrar en consola
$contexto = new ContextoMensaje(new SalidaConsola());
$contexto->mostrarMensaje($mensaje);

// Mostrar en JSON
$contexto->setEstrategia(new SalidaJson());
$contexto->mostrarMensaje($mensaje);

// Guardar en archivo TXT
$contexto->setEstrategia(new SalidaTxt());
$contexto->mostrarMensaje($mensaje);