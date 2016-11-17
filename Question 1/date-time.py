import datetime

range1 = datetime.datetime.strptime("20160104173643", "%Y%m%d%H%M%S")
range2 = datetime.datetime.strptime("20160521101256", "%Y%m%d%H%M%S")

total = range2 - range1
total_secs = total.seconds
secs = total_secs % 60
total_mins = total_secs / 60
mins = total_mins % 60
hours = total_mins / 60

print(int(total.days),'Days', int(hours), 'Hours', int(mins), 'Minutes', int(secs), 'Seconds')