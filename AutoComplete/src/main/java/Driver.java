import java.io.IOException;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.NullWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.lib.db.DBConfiguration;
import org.apache.hadoop.mapreduce.lib.db.DBOutputFormat;
import org.apache.hadoop.mapreduce.lib.input.TextInputFormat;
import org.apache.hadoop.mapreduce.lib.output.TextOutputFormat;


public class Driver {

	public static void main(String[] args) throws ClassNotFoundException, IOException, InterruptedException {
		//job1
		Configuration conf1 = new Configuration();
		//conf1.set("textinputformat.record.delimiter", ".");
		DBConfiguration.configureDB(conf1,
				"com.mysql.jdbc.Driver",
				"jdbc:mysql://192.168.1.101:8889/mrsys_database",
				"root",
				"root");

		Job job1 = Job.getInstance(conf1, "NGram");
		job1.setJarByClass(Driver.class);
		job1.addArchiveToClassPath(new Path("/mysql/mysql-connector-java-5.1.39-bin.jar"));

		job1.setMapperClass(NGramLibraryBuilder.NGramMapper.class);
		job1.setReducerClass(NGramLibraryBuilder.NGramReducer.class);
		job1.setMapOutputKeyClass(Text.class);
		job1.setMapOutputValueClass(Text.class);
		job1.setOutputKeyClass(DBOutputWritable.class);
		job1.setOutputValueClass(NullWritable.class);
		job1.setInputFormatClass(TextInputFormat.class);
		job1.setOutputFormatClass(DBOutputFormat.class);

		DBOutputFormat.setOutput(job1, "autocomplete_table", new String[] {"prefix", "movie_name", "count"});
		TextInputFormat.setInputPaths(job1, new Path(args[0]));
		job1.waitForCompletion(true);

		//how to connect two jobs?
		// last output is second input

		//2nd job
		/*Configuration conf2 = new Configuration();
		conf2.set("threashold", args[3]);
		conf2.set("n", args[4]);

		DBConfiguration.configureDB(conf2,
				"com.mysql.jdbc.Driver",
				"jdbc:mysql://localhost:8889/test",
				"root",
				"root");

		Job job2 = Job.getInstance(conf2);
		job2.setJobName("Model");
		job2.setJarByClass(Driver.class);

		job2.addArchiveToClassPath(new Path("mysql-connector-java-5.1.39-bin.jar"));
		job2.setMapOutputKeyClass(Text.class);
		job2.setMapOutputValueClass(Text.class);
		job2.setOutputKeyClass(Text.class);
		job2.setOutputValueClass(Text.class);
		job2.setMapperClass(LanguageModel.Map.class);
		job2.setReducerClass(LanguageModel.Reduce.class);

		job2.setInputFormatClass(TextInputFormat.class);
		job2.setOutputFormatClass(TextOutputFormat.class);
		//job2.setOutputFormatClass(DBOutputFormat.class);

		//DBOutputFormat.setOutput(job2, "output",
		//		new String[] {"starting_phrase", "following_word", "count"});

		TextInputFormat.setInputPaths(job2, args[1]);
		TextOutputFormat.setOutputPath(job2, new Path(args[5]));
*/
	}

}
