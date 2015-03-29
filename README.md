# Dulles Wait API
A simple PHP JSON API to get the expected wait time at each of the two security checkpoints at Washington Dulles Airport.

This simply screen scrapes data from the Airport's mobile website and serves it up as JSON.

Example response:

```
{ 
    "airports": [ 
        { 
            "iata": "IAD", 
            "name" : "Washington Dulles", 
            "lastUpdated": "2015-03-28 20:23:00", 
            "lastUpdatedTimestamp": 1427588580, 
            "checkpoints": [ 
                { 
                    "name": "East", 
                    "wait" : 2 
                }, 
                { 
                    "name": "West", 
                    "wait" : 0 
                } 
            ] 
        } 
    ] 
}
```

The response JSON contains:

* One airport, as this only works for Dulles
* The IATA code for Dulles, IAD
* Airport name
* lastUpdated is the US Eastern time that the airport last updated their website with security wait times
* lastUpdatedTimestamp is the date above expressed as a UNIX timestamp
* checkpoints is an array of two checkpoint objects, each containing the checkpoint name and wait time in minutes

This API is running here: http://dulleswaitapi.crudworks.org/

There is currently no caching, so whenever you hit the above URL the data will be parsed from the Airport's website.

Feel free to use this as you like, and let me know what use you find for it, if any!  I just did it for entertainment purposes.
