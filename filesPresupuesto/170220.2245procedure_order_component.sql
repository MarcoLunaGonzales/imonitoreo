CREATE DEFINER=`root`@`localhost` PROCEDURE `ordenar_componentes`(IN `usuario`  INTEGER, IN `paramgestion`  INTEGER, IN `cod_proyecto`  INTEGER)
BLOCK1: begin
	DECLARE v_done BOOLEAN DEFAULT false;
	DECLARE indice INT;
	DECLARE codigo_componente INT;
	DECLARE abreviatura VARCHAR(255);
	DECLARE nombre VARCHAR(255);
	DECLARE cod_padre int;
	DECLARE nivel int;
	DECLARE partida varchar(255);


	DECLARE cursor1 CURSOR FOR
	SELECT c.codigo, c.abreviatura, c.nombre, c.cod_padre, c.nivel, c.partida
	FROM componentessis c where c.nivel=1 and c.cod_gestion=paramgestion and c.cod_proyecto=cod_proyecto;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET v_done:=true;
	
	DELETE FROM componentessis_orden;

	SET indice=0;
	open cursor1;
	LOOP1: loop
		SET indice=indice+1;
		FETCH cursor1 INTO codigo_componente, abreviatura, nombre, cod_padre, nivel, partida;
		if v_done then
			close cursor1;
			leave LOOP1;
		end if;
		
		INSERT INTO componentessis_orden (codigo, nombre, abreviatura, nivel, cod_padre, cod_estado, partida, indice, cod_usuario)
		values (codigo_componente, nombre, abreviatura, nivel, cod_padre, 1, partida, indice, usuario);

		BLOCK2: begin
			DECLARE codigo_componente2 INT;
			DECLARE abreviatura2 VARCHAR(255);
			DECLARE nombre2 VARCHAR(255);
			DECLARE cod_padre2 int;
			DECLARE nivel2 int;
			DECLARE partida2 varchar(255);

			declare v_done2 BOOLEAN DEFAULT false;
			DECLARE cursor2 CURSOR FOR
				SELECT c2.codigo, c2.abreviatura, c2.nombre, c2.cod_padre, c2.nivel, c2.partida
				FROM componentessis c2 where c2.cod_padre=codigo_componente and c2.cod_gestion=paramgestion and c2.cod_proyecto=cod_proyecto;

				DECLARE CONTINUE HANDLER FOR NOT FOUND
				set v_done2:= TRUE;
				open cursor2;
				LOOP2: loop
					SET indice=indice+1;
					FETCH cursor2 INTO codigo_componente2, abreviatura2, nombre2, cod_padre2, nivel2, partida2;
					
					IF v_done2 THEN
						close cursor2;
						leave LOOP2;
					end if;

					INSERT INTO componentessis_orden (codigo, nombre, abreviatura, nivel, cod_padre, cod_estado, partida, indice, cod_usuario)
					values (codigo_componente2, nombre2, abreviatura2, nivel2, cod_padre2, 1, partida2, indice, usuario);

					BLOCK3: begin
						DECLARE codigo_componente3 INT;
						DECLARE abreviatura3 VARCHAR(255);
						DECLARE nombre3 VARCHAR(255);
						DECLARE cod_padre3 int;
						DECLARE nivel3 int;
						DECLARE partida3 varchar(255);

						declare v_done3 BOOLEAN DEFAULT false;
						DECLARE cursor3 CURSOR FOR
							SELECT c3.codigo, c3.abreviatura, c3.nombre, c3.cod_padre, c3.nivel, c3.partida
							FROM componentessis c3 where c3.cod_padre=codigo_componente2 and c3.cod_gestion=paramgestion and c3.cod_proyecto=cod_proyecto;

							DECLARE CONTINUE HANDLER FOR NOT FOUND
							set v_done3:= TRUE;
							open cursor3;
							LOOP3: loop
								SET indice=indice+1;
								FETCH cursor3 INTO codigo_componente3, abreviatura3, nombre3, cod_padre3, nivel3, partida3;
								
								IF v_done3 THEN
									close cursor3;
									leave LOOP3;
								end if;

								INSERT INTO componentessis_orden (codigo, nombre, abreviatura, nivel, cod_padre, cod_estado, partida, indice, cod_usuario)
								values (codigo_componente3, nombre3, abreviatura3, nivel3, cod_padre3, 1, partida3, indice, usuario);

							end loop LOOP3;
					end BLOCK3;

				end loop LOOP2;
		end BLOCK2;
	end loop LOOP1;
end BLOCK1