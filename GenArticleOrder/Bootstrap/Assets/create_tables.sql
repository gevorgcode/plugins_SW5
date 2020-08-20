CREATE TABLE IF NOT EXISTS `gen_articles_categories` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`articleID` int(11) NOT NULL,
		`categoryID` int(11) NOT NULL,
		`order` int(11) NOT NULL,
		PRIMARY KEY (`id`),
		KEY `articleId` (`articleID`),
		KEY `categoryId` (`categoryID`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		
CREATE TABLE IF NOT EXISTS `gen_product_streams_sort` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`articleID` int(11) NOT NULL,
		`streamID` int(11) NOT NULL,
		`order` int(11) NOT NULL,
		PRIMARY KEY (`id`),
		KEY `articleId` (`articleID`),
		KEY `streamID` (`streamID`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		
CREATE TABLE IF NOT EXISTS `gen_articles_related_sort` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`relatedarticle` int(11) NOT NULL,
		`articleID` int(11) NOT NULL,
		`sort` int(11) NOT NULL,
		PRIMARY KEY (`id`),
 		KEY `articleId` (`articleID`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `gen_articles_similar_sort` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`relatedarticle` int(11) NOT NULL,
		`articleID` int(11) NOT NULL,
		`sort` int(11) NOT NULL,
		PRIMARY KEY (`id`),
 		KEY `articleId` (`articleID`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;