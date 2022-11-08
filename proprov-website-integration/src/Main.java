import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class Main {

	public static void main(String[] args) {
		String file;
		int task;
		if (args.length > 1) {
			task = Integer.parseInt(args[0]);
			file = args[1];
		}
		else{
			System.out.println("No file name or task number provided.");
			return;
		}

		if(task == 1)
		{
			task1(file);
		}
		else if(task == 2)
		{
			task2(file);
		}
		else if(task == 3)
		{
			task3(file);
		}
		else if(task == 4)
		{
			task4(file);
		}
		else if(task == 5)
		{
			task5(file);
		}
		else if(task == 6)
		{
			task6(file);
		}
		else if(task == 7)
		{
			task7(file);
		}

	}

	public static void task1(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Students#usf", "dataEntity");
		pg1.addVertex("Filtered#org", "dataEntity");
		pg1.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("Filtered#org", "dataEntity");
		pg2.addVertex("Students#usf", "dataEntity");
		pg2.addVertex("CareerFairAttendees#org", "dataEntity");
		pg2.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg2.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Filtered#org", "dataEntity");
		pg3.addVertex("Students#hcc", "dataEntity");
		pg3.addEdge("Filtered#org","wasDerivedFrom", "Students#hcc");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#hcc", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#hcc", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#hcc");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#hcc");
		pg5.addEdge("Students#hcc", "wasAttributedTo", "Registrar#hcc");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(!r2) {
				errors.add("2s");
			}
			if(r3) {
				errors.add("3v");
			}
			if(!r4) {
				errors.add("4s");
			}
			if(r5) {
				errors.add("5v");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task2(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Students#usf", "dataEntity");
		pg1.addVertex("Registrar#usf", "accountAgent");
		pg1.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("Students#usf", "dataEntity");
		pg2.addVertex("Recruiter#org", "accountAgent");
		pg2.addEdge("Students#usf", "wasAttributedTo", "Recruiter#org");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Students#hcc", "dataEntity");
		pg3.addVertex("Registrar#hcc", "accountAgent");
		pg3.addEdge("Students#hcc","wasAttributedTo", "Registrar#hcc");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#hcc", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#hcc", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#hcc");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#hcc");
		pg5.addEdge("Students#hcc", "wasAttributedTo", "Registrar#hcc");
		pg5.addEdge("Students#hcc", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(r2) {
				errors.add("2v");
			}
			if(!r3) {
				errors.add("3s");
			}
			if(r4) {
				errors.add("4v");
			}
			if(!r5) {
				errors.add("5s");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task3(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Filtered#org", "dataEntity");
		pg1.addVertex("CareerFairAttendees#org", "dataEntity");
		pg1.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("CareerFairAttendees#org", "dataEntity");
		pg2.addVertex("Recruiter#org", "accountAgent");
		pg2.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Filtered#org", "dataEntity");
		pg3.addVertex("CareerFairAttendees#org", "dataEntity");
		pg3.addVertex("Recruiter#org", "accountAgent");
		pg3.addEdge("CareerFairAttendees#org","wasAttributedTo", "Recruiter#org");
		pg3.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#usf", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#usf", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#usf");
		pg5.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(r1) {
				errors.add("1v");
			}
			if(r2) {
				errors.add("2v");
			}
			if(!r3) {
				errors.add("3s");
			}
			if(!r4) {
				errors.add("4s");
			}
			if(r5) {
				errors.add("5v");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task4(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Filter", "activity");
		pg1.addVertex("Students#usf", "dataEntity");
		pg1.addEdge("Filter", "used", "Students#usf");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("Map", "activity");
		pg2.addVertex("Students#usf", "dataEntity");
		pg2.addEdge("Map", "used", "Students#usf");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Filter", "activity");
		pg3.addVertex("CareerFairAttendees#org", "dataEntity");
		pg3.addEdge("Filter", "used", "CareerFairAttendees#org");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(!r2) {
				errors.add("2s");
			}
			if(r3) {
				errors.add("3v");
			}
			if(!r4) {
				errors.add("4s");
			}
			if(r5) {
				errors.add("5v");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task5(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Filter", "activity");
		pg1.addVertex("Sgx#intel", "nodeAgent");
		pg1.addVertex("Recruiter#org", "accountAgent");
		pg1.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg1.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("Map", "activity");
		pg2.addVertex("Sgx#intel", "nodeAgent");
		pg2.addVertex("Recruiter#org", "accountAgent");
		pg2.addEdge("Map", "wasAssociatedWith", "Sgx#intel");
		pg2.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("Filter", "activity");
		pg3.addVertex("Sgx#intel", "nodeAgent");
		pg3.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Zchip#ibm","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Zchip#ibm");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Zchip#ibm");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Zchip#ibm");
		pg4.addEdge("Zchip#ibm", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#usf", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#usf", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#usf");
		pg5.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(!r2) {
				errors.add("2s");
			}
			if(r3) {
				errors.add("3v");
			}
			if(r4) {
				errors.add("4v");
			}
			if(!r5) {
				errors.add("5s");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task6(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("Students#usf", "dataEntity");
		pg1.addVertex("Registrar#usf", "accountAgent");
		pg1.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("CareerFairAttendees#org", "dataEntity");
		pg2.addVertex("Recruiter#org", "accountAgent");
		pg2.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("CareerFairAttendees#org", "dataEntity");
		pg3.addVertex("Filter", "activity");
		pg3.addEdge("Filter", "used", "CareerFairAttendees#org");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#usf", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#usf", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#usf");
		pg5.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(!r2) {
				errors.add("2s");
			}
			if(r3) {
				errors.add("3v");
			}
			if(r4) {
				errors.add("4v");
			}
			if(!r5) {
				errors.add("5s");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static void task7(String file) {

		//create provenance graphs
		ProvenanceGraph pg1 = new ProvenanceGraph();
		pg1.addVertex("CareerFairAttendees#org", "dataEntity");
		pg1.addVertex("Filtered#org", "dataEntity");
		pg1.addVertex("Recruiter#org", "accountAgent");
		pg1.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg1.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");

		ProvenanceGraph pg2 = new ProvenanceGraph();
		pg2.addVertex("CareerFairAttendees#org", "dataEntity");
		pg2.addVertex("Filtered#org", "dataEntity");
		pg2.addVertex("Recruiter#org", "accountAgent");
		pg2.addVertex("Students#hcc", "dataEntity");
		pg2.addVertex("Registrar#hcc", "accountAgent");
		pg2.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg2.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg2.addEdge("Filtered#org", "wasDerivedFrom", "Students#hcc");
		pg2.addEdge("Students#hcc", "wasAttributedTo", "Registrar#hcc");

		ProvenanceGraph pg3 = new ProvenanceGraph();
		pg3.addVertex("CareerFairAttendees#org", "dataEntity");
		pg3.addVertex("Filtered#org", "dataEntity");
		pg3.addVertex("Recruiter#org", "accountAgent");
		pg3.addVertex("Students#usf", "dataEntity");
		pg3.addVertex("Registrar#usf", "accountAgent");
		pg3.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg3.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg3.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg3.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");

		ProvenanceGraph pg4 = new ProvenanceGraph();
		pg4.addVertex("Students#usf", "dataEntity");
		pg4.addVertex("CareerFairAttendees#org", "dataEntity");
		pg4.addVertex("FilterContract", "contractEntity");
		pg4.addVertex("Filter", "activity");
		pg4.addVertex("Sgx#intel","nodeAgent");
		pg4.addVertex("Filtered#org", "dataEntity");
		pg4.addVertex("Recruiter#org", "accountAgent");
		pg4.addVertex("Registrar#usf", "accountAgent");
		pg4.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "Students#usf");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "CareerFairAttendees#org");
		pg4.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg4.addEdge("Filter", "used", "FilterContract");
		pg4.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg4.addEdge("Filter", "used", "Students#usf");
		pg4.addEdge("Students#usf", "wasAttributedTo", "Registrar#usf");
		pg4.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg4.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg4.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		ProvenanceGraph pg5 = new ProvenanceGraph();
		pg5.addVertex("Students#hcc", "dataEntity");
		pg5.addVertex("CareerFairAttendees#org", "dataEntity");
		pg5.addVertex("FilterContract", "contractEntity");
		pg5.addVertex("Filter", "activity");
		pg5.addVertex("Sgx#intel","nodeAgent");
		pg5.addVertex("Filtered#org", "dataEntity");
		pg5.addVertex("Recruiter#org", "accountAgent");
		pg5.addVertex("Registrar#hcc", "accountAgent");
		pg5.addEdge("Filtered#org", "wasGeneratedBy", "Filter");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "Students#hcc");
		pg5.addEdge("Filtered#org", "wasDerivedFrom", "FilterContract");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Filtered#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("Filter", "wasAssociatedWith", "Sgx#intel");
		pg5.addEdge("Filter", "used", "FilterContract");
		pg5.addEdge("Filter", "used", "CareerFairAttendees#org");
		pg5.addEdge("Filter", "used", "Students#hcc");
		pg5.addEdge("Students#hcc", "wasAttributedTo", "Registrar#hcc");
		pg5.addEdge("CareerFairAttendees#org", "wasAttributedTo", "Recruiter#org");
		pg5.addEdge("FilterContract", "wasAttributedTo", "Sgx#intel");
		pg5.addEdge("Sgx#intel", "actedOnBehalfOf", "Recruiter#org");

		Policy p = parsePolicy(file);

		if(!checkIncompletePolicy(p)) {
			boolean r1 = p.evaluate(pg1);
			boolean r2 = p.evaluate(pg2);
			boolean r3 = p.evaluate(pg3);
			boolean r4 = p.evaluate(pg4);
			boolean r5 = p.evaluate(pg5);
			List<String> errors = new ArrayList<>();

			if(!r1) {
				errors.add("1s");
			}
			if(r2) {
				errors.add("2v");
			}
			if(!r3) {
				errors.add("3s");
			}
			if(!r4) {
				errors.add("4s");
			}
			if(r5) {
				errors.add("5v");
			}

			if(!errors.isEmpty()) {
				System.out.print("Incorrect: ");
				for(String s: errors) {
					System.out.print(s + ",");
				}
				System.out.println();
			}else {
				System.out.println("Correct");
			}

		}else {
			System.out.println("Incomplete");
		}
	}

	public static boolean checkIncompletePolicy(Policy p) {
		if(p instanceof EdgePolicy) {
			if(((EdgePolicy)p).getSrc() == null || ((EdgePolicy)p).getDst() == null){
				return true;
			}
		}else if(p instanceof NegationPolicy) {
			return checkIncompletePolicy(((NegationPolicy)p).getPolicy());
		}else if(p instanceof BinaryPolicy) {
			return checkIncompletePolicy(((BinaryPolicy)p).getLeftPolicy()) && checkIncompletePolicy(((BinaryPolicy)p).getRightPolicy());
		}else if(p instanceof QuantifiedPolicy) {
			if(((QuantifiedPolicy)p).getVariable() == null || ((QuantifiedPolicy)p).getType() == null) {
				return true;
			}
			return checkIncompletePolicy(((QuantifiedPolicy)p).getPolicy());
		}else if(p == null) {
			return true;
		}

		return false;
	}

	public static Policy parsePolicy(String file) {
		//JSON parser object to parse read file
		ObjectMapper mapper = new ObjectMapper();
		JsonNode root = null;
		try {
			root = mapper.readTree(new File(file));
		}catch(JsonProcessingException e){
			System.out.println(e);
			System.exit(-1);
		}
		catch(IOException e){
			System.out.println(e);
			System.exit(-1);
		}

		try {
			return handlePolicy(root);
		}catch(NullPointerException e)
		{
			System.out.println("Incomplete");
			System.exit(-1);
			return new EdgePolicy("", "", "");
		}
	}

	public static Policy handlePolicy(JsonNode node){
		String type = node.get("nodeType").asText();

		if(type.equals("EdgePolicy"))
		{
			String relation = node.get("relation").asText();
			String src = node.get("src").asText();
			String dst = node.get("dst").asText();
			return new EdgePolicy(relation, src, dst);
		}
		else if(type.equals("NegationPolicy"))
		{
			return new NegationPolicy(handlePolicy(node.get("policy")));
		}
		else if(type.equals("BinaryPolicy"))
		{
			return new BinaryPolicy(handlePolicy(node.get("leftPolicy")), node.get("operator").asText(), handlePolicy(node.get("rightPolicy")));
		}
		else if(type.equals("QuantifiedPolicy"))
		{
			return new QuantifiedPolicy(node.get("quantifier").asText(), node.get("variable").asText(), node.get("type").asText(), handlePolicy(node.get("policy")));
		}
		else{
			System.out.println("Incomplete");
			System.exit(-1);
			return new NegationPolicy();
		}
	}

}
