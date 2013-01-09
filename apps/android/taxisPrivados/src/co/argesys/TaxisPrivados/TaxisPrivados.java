/*
       Licensed to the Apache Software Foundation (ASF) under one
       or more contributor license agreements.  See the NOTICE file
       distributed with this work for additional information
       regarding copyright ownership.  The ASF licenses this file
       to you under the Apache License, Version 2.0 (the
       "License"); you may not use this file except in compliance
       with the License.  You may obtain a copy of the License at

         http://www.apache.org/licenses/LICENSE-2.0

       Unless required by applicable law or agreed to in writing,
       software distributed under the License is distributed on an
       "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
       KIND, either express or implied.  See the License for the
       specific language governing permissions and limitations
       under the License.
 */

package co.argesys.TaxisPrivados;

import android.location.LocationManager;
import android.provider.Settings;
import android.view.KeyEvent;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import org.apache.cordova.*;

public class TaxisPrivados extends DroidGap
{
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        super.setBooleanProperty("keepRunning", true); 
        //super.setIntegerProperty("splashscreen", R.drawable.splash);
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

