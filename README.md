# Kaya-Africa-test

# Impotant Note

I have created the server base on the decription and little was done on the challenge 1 too
I assume all the registered users is an admin

# Hosting 
I have use heroku to host the API
I use PHP Laravel  as the language 


I have Use mysql in the localhost But on heroku I use pgsql which I have found free.

# IMPORTANT ROUTES

User sign up routes:
POST : https://limitless-cliffs-15542.herokuapp.com/api/v1/signup


user sign in routes
POST: https://limitless-cliffs-15542.herokuapp.com/api/v1/signin
use the access token to access the routes

# for the scope of the test you, as a registered user, you can make someone an admin by running this end-point
POST: https://limitless-cliffs-15542.herokuapp.com/api/v1/make_user_admin/1
this is just for the scope of this test, there are ways to get that done easily


Vendor can create shop using this routes:
POST: https://limitless-cliffs-15542.herokuapp.com/api/v1/create-shop


Super Admin can deactivate Vendor using this routes:
POST: https://limitless-cliffs-15542.herokuapp.com/api/v1/deactivate/1


Super Admin can activate Vendor using this routes:
POST: https://limitless-cliffs-15542.herokuapp.com/api/v1/activate/1


Super admin can view each users by their id using this end-point 
GET: https://limitless-cliffs-15542.herokuapp.com/api/get_user/1


Super Admin can get alll the shop using this end point:
GET : https://limitless-cliffs-15542.herokuapp.com/api/v1/get_shop_by_admin


You can get All shops as Super Admin using this end point:
GET: https://limitless-cliffs-15542.herokuapp.com/api/v1/get_shops


And this routes can view shops by id :
GET: https://limitless-cliffs-15542.herokuapp.com/api/v1/get_shop/2



Admin can get All users:
GET: https://limitless-cliffs-15542.herokuapp.com/api/v1/all_users




Notes, I have use A table for the Users which i called the vendor and i have a field that tell if a user is An admin or not.
Then Deactivate means that the user status is 0 while 1 for Activate user. 




# Challenge One 

I use React Js and css for the interface, I just did a brief work of which I am unable to complete due to lesser time and other lttle commitment 
I need to meet up. 

However, I am Unable to to host it because of other timeline I need  meet,

But it can be  run  locally after clone it  by running the following command 

# 1 
npm install >>>> this is to install all th necessary package
# 2
npm start >>>>  to access the web app locally on the available port.



I will try to host if time permit Thanks.

Accept my little effort on the test, I can do better once I have the podium. Thanks . 


I have been commmit directly to heroku, So you might you might not see whole commit statement