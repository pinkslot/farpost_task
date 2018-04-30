CREATE TABLE `farpost_task2`.`users`
( 
	`id` INT NOT NULL auto_increment,
	`email` VARCHAR(255) NOT NULL , 
	`pass_hash` VARCHAR(255) NOT NULL ,
	`reg_token` VARCHAR(255) NOT NULL ,
	`active` bool DEFAULT FALSE  NOT NULL,
	`sid` VARCHAR(255) NULL ,
	PRIMARY KEY (`id`), 
	UNIQUE INDEX `idx_user_email` (`email`)
);
