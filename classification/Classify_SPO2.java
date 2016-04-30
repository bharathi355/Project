package classification;
import java.sql.*;
public class Classify_SPO2 {
	
	static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
	   static final String DB_URL = "jdbc:mysql://localhost/project";

	   //  Database credentials
	   static final String USER = "root";
	   static final String PASS = "";
	   String gene="";
	   	   String current_class="";

	
	   public String spo2_class(String[] data)
		{
			char sex=data[0].charAt(0);
			int age=Integer.parseInt(data[1]);
			int spo2=Integer.parseInt(data[2]); 
			//float pn,ph,pvh,pl,pvl;
			Connection conn = null;
			   Statement stmt = null;
			   try{
			      //STEP 2: Register JDBC driver
			      Class.forName("com.mysql.jdbc.Driver");

			      //STEP 3: Open a connection
			      //System.out.println();
			      //System.out.println("DISSOLVED OXYGEN LEVEL");
			      //System.out.println();
			      
			      ////System.out.println("Connecting to a selected database...");
			      conn = DriverManager.getConnection(DB_URL, USER, PASS);
			     // //System.out.println("Connected database successfully...");
			      
			      /*STEP 4: Execute a query
			      //System.out.println("Creating statement...");
			      //System.out.println();
			      //System.out.println();*/
			      
			      stmt = conn.createStatement();
			      String sql = "SELECT COUNT(*) FROM training_bp";
			      ResultSet rs = stmt.executeQuery(sql);
			      rs.next();
			      float total=(float)rs.getInt(1);
			      ////System.out.println(total);
			      //pn=ph=pvh=pl=pvl=total/5;
				  //>85 very high,66 to 84 high,56 to 65 normal,46 to 55 low,<=45 very low.
					
					if(spo2>105)
					{
						current_class="Very High";
						gene="10000";
					}
					else if(spo2>=101&&spo2<=105)
					{
						current_class="High";
						gene="01000";
					}
					else if(spo2>=95&&spo2<=100)
					{
						current_class="Normal";
						gene="00100";
					}
					else if(spo2>=46&&spo2<=94)
					{
						current_class="Low";
						gene="00010";
					}
					else if(spo2<=45)
					{
						current_class="Very Low";
						gene="00001";
					}
					System.out.println("Name: "+data[3]+"  Age : "+age+"  Sex: "+sex+"  Dissolved Oxygen: "+spo2);
					System.out.println("Class : "+current_class+"  Chromosome : "+gene);
					}
			   catch(Exception e)
			   {}
		return current_class;
		}

}