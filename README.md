Content Performance Analytics
=============================

Calculate articles performance score. Inspired by [Die Welt’s analytics system][1].

## How it works?

Every news organisation has different criteria by which to judge the success of its content. For some, page views are most important, for others, video views, or users' comments. This application enables the definition of maximum and satisfactory values for each of several measurable criteria (to date: views, bounce rate, and average time on page). With these values, a rating is calculated for each item of content which can be monitored (each article). These ratings can then be shared with editors to enable them to make improvements.

The application functions independently of the organisation's CMS. New content items can be registered with the application using an API. This will also be possible in the future with a google spreadsheet.

#### Monitored content listing screenshot:
![Monitored content](app/Resources/screenshot.png?raw=true "Content Performance Analytics - Monitored content")

## Documentation:

* [Installation][2]

##### Content settings:

````
# app/config/parameters.yml

# set maximum points number per content data
max_points_views: 10
max_points_bounce_rate: 20
max_points_avg_time_on_page: 12

# set custom newsroom values for "OK" (60%) results
good_value_views: 400
good_value_bounce_rate: 1.5
good_value_avg_time_on_page: 50
```

Features:
- [x] add content to monitor
    - [x] api
    - [ ] google spreadsheet
- fetch content data:
    - social data:
        - [ ] facebook
        - [ ] likes
        - [ ] tweets
        - [ ] reddit
    - [x] views (GA)
    - [ ] scroll depth
    - [x] bounce rate (GA)
    - [x] time on screen (GA)
    - [ ] related content clicks
    - [ ] comments number
    - [ ] ?bought subscriptions?

# [Contributions welcome](http://contributionswelcome.org/)

All contributions (no matter if small) are always welcome.

[1]: http://www.niemanlab.org/2016/05/die-welts-analytics-system-de-emphasizes-clicks-and-demystifies-what-it-considers-a-quality-story/
[2]: doc/installation.md
