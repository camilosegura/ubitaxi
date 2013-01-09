package co.argesys.TaxisPrivados;

import android.content.Context;
import android.location.Location;
import android.location.LocationListener;
import android.os.Bundle;
import android.webkit.WebView;
import android.widget.Toast;


public class MyLocationListener implements LocationListener {

	private double lat;
	private double lng;
	private double alt;
	private double speed;
	private String time;	
	private WebView myWebView;
	private TaxisPrivados main;
	Context mc;

	public MyLocationListener(Context mc, TaxisPrivados main) {		
		this.main = main;
		this.mc = mc;		
	}

	public void onLocationChanged(Location location) {
		// TODO Auto-generated method stub
		lat = location.getLatitude();
		lng = location.getLongitude();
		alt = location.getAltitude();
		speed = location.getSpeed();
		time = String.valueOf(location.getTime());  				
		this.main.sendJavascript("window.locator.sendLocation('"+Double.toString(lat)+"','"+Double.toString(lng)+"','"+Double.toString(alt)+"','"+Double.toString(speed)+"','"+time+"');");		
	}

	public void onProviderDisabled(String provider) {
		// TODO Auto-generated method stub

	}

	public void onProviderEnabled(String provider) {
		// TODO Auto-generated method stub

	}

	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub


	}

}
