#include <iostream>
using namespace std;

class Student {
	public:
		string name;
		string stuno;
		string college;
		string major;
		string sex;
		string addr;
		string phone;

		void init(string name,string stuno,string college,string major,string sex,string addr,string phone) {
			this->name = name;
			this->stuno = stuno;
			this->college = college;
			this->major = major;
			this->sex = sex;
			this->addr = addr;
			this->phone = phone;
		}

		void output() {
			cout<<name<<" ";
			cout<<stuno<<" ";
			cout<<college<<" ";
			cout<<major<<" ";
			cout<<sex<<" ";
			cout<<addr<<" ";
			cout<<phone<<endl;
		}
};

int main() {

	int n,i;
	string name;
	string stuno;
	string college;
	string major;
	string sex;
	string addr;
	string phone;

	cin>>n;
	Student *stu = new Student[n]();
	for(i=0; i<n; i++) {
		cin>>name>>stuno>>college>>major>>sex>>addr>>phone;
		stu[i].init(name,stuno,college,major,sex,addr,phone);
	}

	for(i=0; i<n; i++) {
		stu[i].output();
	}

	delete [] stu;
	stu = NULL;
	return 0;
}
