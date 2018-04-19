<?php

/**
 * Conn.class [ CLASSE PDO DE CONEXÃO COM O BANCO DE DADOS ]
 * Padrão SingleTon.
 * Retorna um objeto PDO
 */
class Conn {

    // Atributos necessários para estabelecer a conexão
    private static $Host = HOST; // servidor
    private static $User = USER; // usuário
    private static $Pass = PASS; // senha
    private static $Dbsa = DBSA; // banco

    /** @var PDO
     * Atributo que armazena a conexão e retorna o objeto PDO
     * Só executa a conexão se o connet naõ estiver inicializado (null) - SingleTon
     * Se na próxima conexão o connect estiver null, utiliza-se o mesmo objeto, não é preciso reconectar
     */
    private static $Connect = null;

    /**
     * Retorna um objeto PDO!
     * Conecta com o banco de dados com o Pattern Singleton.
     * Previne que se tenha apenas uma instância do objeto sendo executado na memória.
     * Padrão ágil de execução do código.
     */
    public function Conectar() {
        try {
            if (self::$Connect == null): // Só um objeto da classe instanciada na memória do servidor (Singleton)
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa; // dsn para MySQL
                $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']; // BD trabalhar com UTF-8
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }

        // Configuração para setar o tipo de erro que o PDO vai trabalhar
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect; // Retorna o objeto PDO
    }

}
