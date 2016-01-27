import urllib, subprocess

class SanityTests:

    site_urls = ["http://jesusmarket.org",
                 "http://jesusmarket.org/live/",
                 "http://jesusmarket.org/arhiva-video/",
                 "http://jesusmarket.org/?sermons-category=visul-nu-e-de-vanzare",
                 "http://jesusmarket.org/?sermons-category=calatoria-vietii-tale",
                 "http://jesusmarket.org/?sermons-category=sa-fie-lumina",
                 "http://jesusmarket.org/?sermons-category=programe-speciale",
                 "http://jesusmarket.org/events-timeline/",
                 "http://jesusmarket.org/despre/",
		 "http://jesusmarket.org/blog/",
                 "http://jesusmarket.org/despre/nicu-butoi/",
                 "http://jesusmarket.org/despre/misiune/",
                 "http://jesusmarket.org/gradina-rugaciunii/",
                 "http://jesusmarket.org/contact/"];

    def check_site_url(site_urls):
        status_list = [];

        for url in site_urls:
            code = urllib.urlopen(url).getcode();

            if(code != 200):
                status_list.append([code,url]);

        return status_list;



    if(len(check_site_url(site_urls)) > 0):
        print("Warning! The following URLs have issues:");
        for site in check_site_url(site_urls):
            print (site);
	
	
	print("");
	print(subprocess.call(["top", "-n", "1", "-b"]));
        exit(1);

    else:
        exit(0);
