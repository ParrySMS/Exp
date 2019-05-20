#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CPeople {

	protected:
		string name;
		string sex;
		int age;



	public:
		CPeople() {}
		CPeople(string _name,string _sex,int _age) {
			name = _name;
			sex = _sex;
			age = _age;
		}

		void init(string _name,string _sex,int _age) {
			name = _name;
			sex = _sex;
			age = _age;
		}

		void echo(string title = "People") {
			cout<<title<<":"<<endl;
			cout<<"Name: "<<name<<endl;
			cout<<"Sex: "<<sex<<endl;
			cout<<"Age: "<<age<<endl;
		}

		int getAge() {
			return age;
		}

		string getName() {
			return name;
		}

		string getSex() {
			return sex;
		}

};


class CStu : virtual public CPeople {

	protected:
		string stuno;
		double point;

	public:
		CStu() {}
		CStu(string _name,string _sex,int _age,
		     string _stuno,double _point)
			:CPeople(_name,_sex,_age) {
			stuno = _stuno;
			point = _point;
		}

		CStu(string _stuno,double _point) {
			stuno = _stuno;
			point = _point;
		}

		CStu(CPeople &cp,string _stuno,double _point)
			:CPeople(cp.getName(),cp.getSex(),cp.getAge()) {
			stuno = _stuno;
			point = _point;
		}

		void showStu() {
			cout<<endl;
			this->echo("Student");
			cout<<"No.: "<<stuno<<endl;
			cout<<"Score: "<<point<<endl;
		}
};

class CTech: virtual public CPeople {
	protected:
		string aprt;
		string job;

	public:
		CTech() { }
		CTech(string _name,string _sex,int _age,
		      string _aprt,string _job)
			:CPeople(_name,_sex,_age)  {
			aprt = _aprt;
			job = _job;
		}

		CTech(CPeople &cp,string _aprt,string _job)
			:CPeople(cp.getName(),cp.getSex(),cp.getAge()) {
			aprt = _aprt;
			job = _job;
		}

		CTech(string _aprt,string _job) {
			aprt = _aprt;
			job = _job;
		}

		void showTch() {
			cout<<endl;
			this->echo("Teacher");
			cout<<"Position: "<<job<<endl;
			cout<<"Department: "<<aprt<<endl;
		}
};

class CGOK:public CStu,public CTech {
	protected:
		string dirc;
		string tutor;
	public:
		CGOK() {	}

		CGOK(string _name,string _sex,int _age,
		     string _stuno,double _point,
		     string _aprt,string _job,
		     string _dirc,string _tutor)

			:CPeople(_name,_sex,_age),
			 CStu(_stuno,_point),
			 CTech(_aprt, _job) {
			dirc = _dirc;
			tutor = _tutor;
		}


		void showGok() {
			cout<<endl;
			this->echo("GradOnWork");
			cout<<"No.: "<<stuno<<endl;
			cout<<"Score: "<<point<<endl;
			cout<<"Position: "<<job<<endl;
			cout<<"Department: "<<aprt<<endl;
			cout<<"Direction: "<<dirc<<endl;
			cout<<"Tutor: "<<tutor<<endl;
		}

};


int main() {
	string _name;
	string _sex;
	int _age;
	string _stuno;
	double _point;
	string _aprt;
	string _job;
	string _dirc;
	string _tutor;

	cin>>_name>>_sex>>_age;

	CPeople peo(_name,_sex,_age);
	peo.echo();

	cin>>_stuno>>_point;
	CStu stu(peo,_stuno,_point);
	stu.showStu();

	cin>>_aprt>>_job;
	CTech tch(peo,_job,_aprt);
	tch.showTch();

	cin>>_dirc>>_tutor;
	CGOK gok(_name,_sex,_age,_stuno,_point,_job,_aprt,_dirc,_tutor);
	gok.showGok();


	return 0 ;
}


