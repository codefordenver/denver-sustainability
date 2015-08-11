> View this project's Kanban board for tasks here: [![Stories in Ready](https://badge.waffle.io/codefordenver/denver-sustainability.png?label=ready&title=Ready)](http://waffle.io/codefordenver/denver-sustainability)

# Denver Sustainability
### _Promoting building energy efficiency in Denver_

The energy used in commercial buildings, apartments and condos is responsible for 57% of the greenhouse gas emissions in Denver. Together we can cut that by 20% for $1.3 billion in energy savings. The first step in improving energy efficiency is to measure it. You know the miles per gallon of your car, but do you know the 1-100 ENERGY STAR score of the buildings where you live and work?


## Running locally
This project is built on top of [loopback](http://loopback.io/) from [Strongloop](https://strongloop.com/node-js/api-platform/).

You will need [Node.js](https://nodejs.org/) to run. After cloning, run `npm install` to install the necessary dependencies.

While you can run the app with just `npm start`, you will probably want to use strongloop's suite of tools. Install these with `npm install -g strongloop`, and then run `slc run`.

This will open the app at <http://localhost:3000/>,
and an api explorer at <http://localhost:3000/explorer>

### Developing
Strongloop has a series of powerful tools for developing and managing applications. After installing the `strongloop` node module (see above):
 - `slc loopback` is a powerful generator for modifying the api
 - `slc arc` provides a GUI alternative for modifying the api

More info on Strongloop and their tools can be found on their [website](https://strongloop.com/)
Docs and tutorials for using Strongloop can be found [here](http://docs.strongloop.com/display/SL/Installing+StrongLoop)

Client code for the browser can be found in the [client](client) directory.
