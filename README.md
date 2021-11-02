# Boxing-Fitness-App


### Introduction

I have been struggling to keep my weight under control during corona with all the gyms being closed and no sports clubs being open. Martial arts have always been one of my interests and I used to train boxing a few years ago. In my basement I have a punchbag that I like to hit regularly but I'm pretty sure as the training session goes on that my punches get weaker and slower. I needed something to keep track of my punching performance and stop me from slacking off.


### The Solution

I attached a force sensing resistor to each of my boxing gloves and wired it to an Arduino microcontroller to read the input data as shown in picture 1.

![Boxing Glove with Sensors Attatched](https://raw.githubusercontent.com/ShaunHaldane/images/main/BoxingGloveWithArduino.png)
Picture 1: Force Sensing Resistor and Arduino Attached to Boxing Glove


I wired up a Bluetooth module to each Arduino so they could communicate wirelessly to a computer. I have also used HTML, CSS and Javascript for the front-end so that the product could run in the browser and be used as a website. That means that it is portable and I can use this equipment on another machine from anywhere and other people can create an account and use it for themselves.

To take input data from the Arduino, I used a python script to trigger key press events on the computer keyboard as shown in picture 2.

![Python Code for Controller](https://raw.githubusercontent.com/ShaunHaldane/images/main/PythonControllerBoxingApp.png)
Picture 2: Python Controller


As shown in picture 2, key 1 is triggered when a soft right punch has landed, key 2 is pressed when a medium right punch has landed and key 3 is pressed when a hard right punch has landed.

When the user logs in to the app they have the option to select the number of rounds for the session as shown in picture 3.

![Start Screen](https://raw.githubusercontent.com/ShaunHaldane/images/main/BoxingAppStartScreen.png)
Picture 3: Start Screen of App.


Each round is 3min with a 1min break to simulate a boxing timer. Boxing combinations are called in sequence from an array of audio tracks and the user has to throw the combination displayed on the screen as shown in picture 4.

![Game Screen](https://raw.githubusercontent.com/ShaunHaldane/images/main/BoxingAppSessionScreen.png)
Picture 4: Game Screen


During the session, the key press events are being counted to add up strength and speed of the punches to calculate a final score for the session. At the end of the session the score is added to a database to compare to previous sessions and measure any increase in performance as shown in picture 5.

![Results Screen](https://raw.githubusercontent.com/ShaunHaldane/images/main/BoxingAppSessionResultsScreen.png)
Picture 5: Results Screen


Picture 6 shows me using the app in real time.

![Me Punching the Bag](https://raw.githubusercontent.com/ShaunHaldane/images/main/MePunchingBag.png)
Picture 6: Me Using the Equipment


### Conclusion

I have built this product to help me get boxing fit again. Only time will tell if I stick to a good routine of using this product to measure my fitness. I am going to update this post at Christmas 2021 to show my results of using this product for 8 weeks.
