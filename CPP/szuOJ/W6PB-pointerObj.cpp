#include <iostream>
#include <cstring>
#include <algorithm>
#include <math.h>
#include <iomanip>
using namespace std;
class Student {
	public:
		string name;
		string sex;
		string stuno;
		string college;
		string phone;

		Student() {};
		Student(string name,string sex,string stuno,string college,string phone)
			:name(name),sex(sex),stuno(stuno),college(college),phone(phone) {
		};

		void init(string name,string sex,string stuno,string college,string phone) {
			this->name = name;
			this->sex = sex;
			this->stuno = stuno;
			this->college = college;
			this->phone = phone;
		}

};

bool cmp(Student x,Student y) {
	int i = 0;
	while(x.name[i] && y.name[i]) {
		if (x.name[i] == y.name[i]) {
			i++;
			continue;
		}

		if(x.name[i]<y.name[i])	return 1;
	}
}


int main() {
	int i,n;


	string name;
	string sex;
	string stuno;
	string college;
	string phone;

	cin>>n;
	Student* stu_arr = new Student[n];
	for(i=0; i<n; i++) {
		cin>>name>>sex>>stuno>>college>>phone;
		stu_arr[i].init(name,sex,stuno,college,phone);
	}

	sort(stu_arr,stu_arr+n,cmp);
	for(i=0; i<n; i++) {
		cout<<stu_arr[i].name<<endl;
	}

	delete [] stu_arr;
	return 0;
}
