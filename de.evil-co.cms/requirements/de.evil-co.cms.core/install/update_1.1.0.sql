UPDATE 
	`wcf1_page_module_option`
SET
	optionID = optionID + 1
WHERE
	optionID >= 3;

INSERT INTO 
	`wcf1_page_module_option` (`optionID`, `moduleID`, `name`, `optionType`, `defaultValue`, `cssClass`, `groupID`, `displayDescription`, `fields`) 
VALUES
	(3, 2, 'cssClass', 'text', 'content', 'inputText', 2, 1, '');