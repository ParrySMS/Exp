#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

class Animal {
	protected:
		string name;
		int age;
	public:
		Animal() {}
		Animal(string _name,int _age) {
			name = _name;
			age = _age;
		}

		void init(string _name,int _age) {
			name = _name;
			age = _age;
		}

		virtual void speak() = 0;

};

class Tiger:public Animal {
	protected:
		string sound;
	public:
		Tiger() {}
		Tiger(string _name,int _age)
			:Animal(_name,_age) {
			sound = "AOOO";
		}
		void speak() {
			cout<<"Hello,I am "<<name<<","<<sound<<"."<<endl;
		}
};

class Dog:public Animal {
	protected:
		string sound;
	public:
		Dog() {}
		Dog(string _name,int _age)
			:Animal(_name,_age) {
			sound = "WangWang";
		}

		void speak() {
			cout<<"Hello,I am "<<name<<","<<sound<<"."<<endl;
		}
};

class Duck:public Animal {
	protected:
		string sound;
	public:
		Duck() {}
		Duck(string _name,int _age)
			:Animal(_name,_age) {
			sound = "GAGA";
		}

		void speak() {
			cout<<"Hello,I am "<<name<<","<<sound<<"."<<endl;
		}
};

class Pig:public Animal {
	protected:
		string sound;
	public:
		Pig() {}
		Pig(string _name,int _age)
			:Animal(_name,_age) {
			sound = "HENGHENG";
		}

		void speak() {
			cout<<"Hello,I am "<<name<<","<<sound<<"."<<endl;
		}
};

int main() {
	int t,i;
	string type,name;
	int age;
	Animal * an;
	cin>>t;
	while(t--) {
		cin>>type>>name>>age;
		if(type == "Tiger") {
			an = new Tiger(name,age);
			an->speak();
		} else if(type == "Dog") {
			an = new Dog(name,age);
			an->speak();
		} else if(type == "Pig") {
			an = new Pig(name,age);
			an->speak();
		} else if(type == "Duck") {
			an = new Duck(name,age);
			an->speak();
		} else {
			cout<<"There is no "<<type<<" in our Zoo."<<endl;
			continue;
		}
	}

	delete an;
	return 0 ;
}


