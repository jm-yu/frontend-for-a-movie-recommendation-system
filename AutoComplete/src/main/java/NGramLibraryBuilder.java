import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.NullWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Mapper.Context;
import org.apache.hadoop.mapreduce.Reducer;

import java.io.IOException;

public class NGramLibraryBuilder {
	public static class NGramMapper extends Mapper<LongWritable, Text, Text, Text> {
		@Override
		public void setup(Context context) {
			Configuration conf = context.getConfiguration();
			//how to get n-gram from command line?
		}

		// map method
		@Override
		public void map(LongWritable key, Text value, Context context) throws IOException, InterruptedException {
			
			String line = value.toString();
			
			line = line.trim().toLowerCase();

			String[] strs = line.split(",");
			//how to build n-gram based on array of words?
			String movie_name = strs[1];
			//context.write(new Text(movie_name.substring(0,2)), new Text(movie_name));
			int start = Math.min(1, movie_name.length() - 1);
			int end = Math.min(9, movie_name.length() - 1);
			for(int i = start; i < end; i++){
			    String starting_phrase = movie_name.substring(0,i);
				context.write(new Text(starting_phrase), new Text(movie_name));
			}
		}
	}

	public static class NGramReducer extends Reducer<Text, Text, DBOutputWritable, NullWritable> {
		// reduce method
		@Override
		public void reduce(Text key, Iterable<Text> values, Context context)
				throws IOException, InterruptedException {
			int num = 0;
			for(Text value: values) {
				if (num > 5){
					break;
				}
				context.write(new DBOutputWritable(key.toString().trim(), value.toString().trim(), 1), NullWritable.get());
				num++;
			}
		}
	}

}
