create table jom_user_reward_activity (id int primary key auto_increment, sourceUserId int, targetUserId int, giftId int, referenceId int, giftValue float, activityStatus int,  lastUpdate datetime, transactionType int);

create table jom_user_point (id int primary key auto_increment, userId int, balance_point float, withdrawal_point float, lastUpdate datetime);

create table jom_user_topup_activity (id int primary key auto_increment, userId int, description varchar(255), valuePoint float, actualValue decimal(10, 2), paymentTransactionId int, lastUpdate datetime);

create table jom_user_package (id int primary key auto_increment, packageCode varchar(50), description varchar(255), valuePoint int, lastUpdate datetime);

insert into jom_user_package (packageCode, description, valuePoint) values ('PKG1', 'Package 1', 100);
insert into jom_user_package (packageCode, description, valuePoint) values ('PKG2', 'Package 2', 200);
insert into jom_user_package (packageCode, description, valuePoint) values ('PKG3', 'Package 3', 300);


create table jom_user_withdrawal_activity (id int primary key auto_increment, userId int, bankCountry varchar(50), name varchar(100), bankName varchar(100), mepsRouting varchar(50), acctnum varchar(50),  withdrawal_date datetime, withdrawal_amount float, status int, payment_method int, approvedByUser int, lastUpdate datetime);

create table jom_gift (id int primary key auto_increment, description varchar(255), valuePoint float, imageURL varchar(500), updatedByUser int, lastUpdate datetime); 

-- newly introduced on 25-Sept-2013 -- 
create table jom_point_system_config (id int primary key auto_increment, pointValuePerDollar float, currencyId int, lastUpdate datetime);

create table jom_currency (id int primary key auto_increment, currencyCode varchar(3), description varchar(255), lastUpdate datetime);

create table jom_system_config (id int primary key auto_increment, minimum_withdrawal_amount float, max_withdrawal_amount float, lastUpdate datetime);

create table jom_withdrawal_status (id int primary key auto_increment, code varchar(10), desciption	varchar(255), lastUpdate datetime);

create table jom_payment_method (id int primary key auto_increment, code varchar(10), desciption varchar(255), lastUpdate datetime);


-- do not need this as we do not want end user to have access here. 

 insert into jom_menu
 (menutype, path, img, params, title, alias, link, type, published, parent_id, level, component_id, ordering, checked_out, browserNav, access, template_style_id, lft, rgt, home, client_id)
 values
 ('jomsocial', '', '', '', 'Configure Gift', 'configure-gift', 'index.php?option=com_community&view=configureGift', 'component', 1, 141, 2, 10000, 0, 0, 0, 1, 0, 85, 86, 0, 0);
 
 insert into jom_menu
 (menutype, path, img, params, title, alias, link, type, published, parent_id, level, component_id, ordering, checked_out, browserNav, access, template_style_id, lft, rgt, home, client_id)
 values
 ('jomsocial', '', '', '', 'Like', 'show-support', 'index.php?option=com_community&view=mysupport', 'component', 1, 1, 1, 10000, 0, 0, 0, 2, 0, 121, 121, 0, 0);
 
 
 insert into jom_menu
 (menutype, path, img, params, title, alias, link, type, published, parent_id, level, component_id, ordering, checked_out, browserNav, access, template_style_id, lft, rgt, home, client_id)
 values
 ('jomsocial', '', '', '', 'Who like me', 'mysupport', 'index.php?option=com_community&view=mysupport', 'component', 1, 179, 2, 10000, 0, 0, 0, 1, 0, 121, 121, 0, 0);
  
 insert into jom_menu
 (menutype, path, img, params, title, alias, link, type, published, parent_id, level, component_id, ordering, checked_out, browserNav, access, template_style_id, lft, rgt, home, client_id)
 values
 ('jomsocial', '', '', '', 'Topup credit', 'topupcredit', 'index.php?option=com_community&view=topupcredit', 'component', 1, 179, 2, 10000, 0, 0, 0, 1, 0, 121, 121, 0, 0);
  
 insert into jom_menu
 (menutype, path, img, params, title, alias, link, type, published, parent_id, level, component_id, ordering, checked_out, browserNav, access, template_style_id, lft, rgt, home, client_id)
 values
 ('jomsocial', '', '', '', 'Withdraw credit', 'mywithdrawal', 'index.php?option=com_community&view=mywithdraw', 'component', 1, 179, 2, 10000, 0, 0, 0, 1, 0, 121, 121, 0, 0);