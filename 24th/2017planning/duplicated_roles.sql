SELECT `SS`.`sessionNo`,  `DR`.`english_sirname`,  `DR`.`english_firstname`, `SS`.`class`,
        `SS`.`begin`, `SS`.`duration`  FROM `doctor_tbls` AS `DR`
        INNER JOIN (`role_tbls` AS `RL` INNER JOIN  `session_tbls` AS `SS`
        ON `RL`.`sessionNo` = `SS`.`sessionNo` AND `RL`.`class` = `SS`.`class`)
        ON  `DR`.`id` = `RL`.`dr_tbl_id`
        WHERE `SS`.`begin` <> '00:00:00'   AND `SS`.`sessionNo` > '0' AND `SS`.`year` = '2017'
        ORDER BY `SS`.`class` DESC, `SS`.`sessionNo` ASC,`DR`.`english_sirname` ASC,
        `DR`.`english_firstname` ASC,  `SS`.`begin` ASC, `SS`.`duration` DESC