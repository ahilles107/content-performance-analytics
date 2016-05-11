Content Performance Analytics
=============================

Calculate articles performance score. Inspired by [Die Welt’s analytics system][1].

Application can work independently from current organization CMS. New content items can be added to system by API (with google spreadsheet - when implemented).

Monitored content listing screenshot:
![Monitored content](app/Resources/screenshot.png?raw=true "Content Performance Analytics - Monitored content")

Content settings:

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
        - [ ] redit
    - [x] views (GA)
    - [ ] scroll depth
    - [x] bounce rate (GA)
    - [x] time on screen (GA)
    - [ ] related content clicks
    - [ ] comments number
    - [ ] ?bought subscriptions?

[1]: http://www.niemanlab.org/2016/05/die-welts-analytics-system-de-emphasizes-clicks-and-demystifies-what-it-considers-a-quality-story/
