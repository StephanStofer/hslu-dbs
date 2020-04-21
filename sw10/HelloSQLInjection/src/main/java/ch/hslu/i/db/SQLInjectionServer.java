package ch.hslu.i.db;

import java.io.IOException;
import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.eclipse.jetty.server.Server;
import org.eclipse.jetty.servlet.ServletHandler;

import java.awt.Desktop;
import java.net.URI;


/*
(c) Programmed by Michael Kaufmann HSLU 2020
To prepare the DB:
1.) create schema UNI
2.) add UNI-data
3.) Alter  table studenten add column passwort text;
4.) update studenten set passwort = name;
5.) http://localhost:8080
6.) Enter pw: "' or 'x'='x" (without double quotes
 */

public class SQLInjectionServer {

    private static Connection connection;

    static String dbuser = "root";
    static String dbpw = "x/f28D9hn9y?+2avmzg%}8RuF[GN";
    static String url = "jdbc:mysql://localhost:3306/uni4?&serverTimezone=Europe/Zurich";

    public static Server createServer(int port) {
        Server server = new Server(port);
        ServletHandler handler = new ServletHandler();
        server.setHandler(handler);
        handler.addServletWithMapping(HelloServlet.class, "/*");
        return server;
    }

    public static void main(String[] args) throws Exception {
        try {
            connection = DriverManager.getConnection(url, dbuser, dbpw);
        } catch (Exception e) {
            e.printStackTrace();
        }

        Server server = createServer(8080);
        if (Desktop.isDesktopSupported() && Desktop.getDesktop().isSupported(Desktop.Action.BROWSE)) {
            server.start();
            Desktop.getDesktop().browse(new URI("http://127.0.0.1:8080"));
            server.join();

        }
    }

    @SuppressWarnings("serial")
    public static class HelloServlet extends HttpServlet {

        @Override
        protected void doGet(HttpServletRequest request,
                             HttpServletResponse response) throws IOException {
            displayUI(response, "", "");
        }

        protected void doPost(HttpServletRequest request,
                              HttpServletResponse response) throws ServletException, IOException {
            String username = request.getParameter("username");
            String password = request.getParameter("password");
            displayUI(response, username, password);

        }

        private String getData(String user, String pw) {
            String s = "";
            java.sql.Statement statement;
            try {
                // server side prepared statement
                PreparedStatement ps = connection.prepareStatement("EXECUTE login_statement using ?, ?");
                ps.setString(1,user);
                ps.setString(2,pw);
                ResultSet resultset = ps.executeQuery();


                // client side prepared statement
                /*PreparedStatement ps = connection.prepareStatement("SELECT * from Studenten s join prüfen p on s" +
                        ".MatrNr = p.MatrNr " +
                        "Where " +
                        "s.Name = ? and s.Passwort = ?");
                ps.setString(1, user);
                ps.setString(2, pw);
                ResultSet resultset = ps.executeQuery();*/

                // vulnerable
                /*statement = connection.createStatement();
                String query = "Select *\n"
                        + "From Studenten s join prüfen p on s.MatrNr = p.MatrNr \n"
                        + "Where s.Name = '" + user + "' and\n"
                        + "s.Passwort = '" + pw + "'";*/
                //System.out.println(query);

                ResultSetMetaData rsmd = resultset.getMetaData();
                int size = resultset.getMetaData().getColumnCount();
                s = "<table>";
                s += "<tr>";
                for (int i = 0; i < size; i++) {
                    s += "<td>" + rsmd.getColumnName(i + 1) + "</td>";
                }
                s += "</tr>";
                while (resultset.next()) {
                    s += "<tr>";
                    for (int i = 0; i < size; i++) {
                        s += "<td>" + resultset.getString(i + 1) + "</td>";
                    }
                    s += "</tr>";
                }
                s += "</table><br/><br/>The query was: <pre>" + ps.toString() + "</pre>";
            } catch (SQLException ex) {
                Logger.getLogger(SQLInjectionServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            return s;
        }

        private void displayUI(HttpServletResponse response, String user, String pw) throws IOException {
            response.setStatus(HttpServletResponse.SC_OK);
            response.setContentType("text/html");
            response.setCharacterEncoding("utf-8");
            response.getWriter().println("<h1>SQL Injection Example with UniDB</h1><form method=\"post\" >\n"
                    + "    Username: <input type=\"text\" name=\"username\" value=\"" + user + "\"/> <br/>\n"
                    + "    Password: <input type=\"password\" name=\"password\" value=\"" + pw + "\"/> <br/>\n"
                    + "    <input type=\"submit\" value=\"Login\" />\n"
                    + "</form>" + getData(user, pw));
        }
    }
}