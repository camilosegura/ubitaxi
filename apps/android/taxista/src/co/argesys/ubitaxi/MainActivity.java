package co.argesys.ubitaxi;

import org.apache.cordova.DroidGap;

import android.location.LocationManager;
import android.os.Bundle;
import android.provider.Settings;
import android.view.KeyEvent;
import android.view.Window;
import android.view.WindowManager;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;

public class MainActivity extends DroidGap {

	
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);        
        super.setBooleanProperty("keepRunning", true); 
        super.setIntegerProperty("splashscreen", R.drawable.splash);
        super.loadUrl("file:///android_asset/www/index.html", 10000);
     
        myLocation();
    }
    
    public void myLocation(){
    	// Acquire a reference to the system Location Manager
    	LocationManager locationManager = (LocationManager) this.getSystemService(Context.LOCATION_SERVICE);    	
    	
    	boolean enabled = locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);

		// Check if enabled and if not send user to the GSP settings
		// Better solution would be to display a dialog and suggesting to 
		// go to the settings
		if (!enabled) {
		  Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
			startActivity(intent);
		}     		
   		//locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 5*1000, 0, new MyLocationListener(this, this));
		locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 5*1000, 0, new MyLocationListener(this, this));   		
    }       
    
    //override some buttons
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
    	//Log.d("button", new Integer(keyCode).toString());
    	
        if ((keyCode == KeyEvent.KEYCODE_BACK)) {
            return true;
        }
        else if ((keyCode == KeyEvent.KEYCODE_CALL)) {
            return true;
        }else if((keyCode == KeyEvent.KEYCODE_MENU)){
        	return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}
