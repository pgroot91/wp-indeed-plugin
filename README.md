# wp-indeed-plugin
it  get jobs from indeed api to you mysql database small plugin i created  you will find many plugins importing jobs to  post and  pages but not on tables you created which are more of a requirement . in this plugin i have assigned a  cron job of an hourly bases feel free to contact 
please have some informationa bout how to start with plugin development on wp 
 hello world of the plugin development will be enough to understand
to make this work in the 
plugins directory of wp-content folder of your wordpress website 
make a folder name as the name of the php file in the project
mine is my-first-plugin

the code is not at all complicated to work with 

we have 2 wp hooks 
one for the main function 
other to assign the cron job 

anything  you echo in the project will appear in
settings of wordpress and then plugin name 

i have my first function just sending out a curl request and providing infomation 
the information is in json format and is parsed and queried to the table 

my table name is indeed and from the input of xml parsing i inseted the data into the table i created in the application 




