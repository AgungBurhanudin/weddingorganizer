<?php

//SELECT * FROM tbl_product WHERE tag::jsonb @> ANY (ARRAY ['["xx"]','["oo"]']::jsonb[]); or
//SELECT * FROM tbl_product WHERE tag::jsonb @> '["cc","bb"]'::jsonb; and
//SELECT * FROM tbl_product WHERE tag::jsonb @> '"xx"'::jsonb; satu

