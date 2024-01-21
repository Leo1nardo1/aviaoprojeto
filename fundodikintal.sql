create database fundodikintal;
use fundodikintal;
CREATE TABLE Voo (
    idVoo INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Origem VARCHAR(255),
    Destino VARCHAR(255),
    AssentosDisponiveis INT,
    ValorPassagem DECIMAL(10, 2)
); 
CREATE TABLE Reserva (
	idReserva INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Voo_idVoo INT NOT NULL,
    nome_cliente varchar(100),
    assento_reservado INT,
    desconto DECIMAL(5,2),
    valorFinal DECIMAL(10, 2),
    FOREIGN KEY(Voo_idVoo) REFERENCES Voo(idVoo) 
    ON DELETE CASCADE
);
ALTER TABLE Reserva AUTO_INCREMENT = 1;
