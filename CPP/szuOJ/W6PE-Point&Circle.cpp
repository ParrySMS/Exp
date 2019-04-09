#include<cmath>
#include <iostream>
using namespace std;


class Point {
	public:
		double x,y;
		Point() {};
		Point(double x,double y):x(x),y(y) {};
		init(double x,double y){
			this->x = x;
			this->y = y;
		} 

};

class Circle {
	public:
		Point *center;
		double radius;
		Circle() {};
		Circle(double x,double y,double r)
			:center(new Point(x,y)),radius(r) {};

		double getDis(Point p) {
			double dx = p.x - center->x;
			double dy = p.y - center->y;
			return sqrt(pow(dx,2)+pow(dy,2));
		}

};

int main() {
	int x,y,r,n,i;
	cin>>x>>y>>r;
	Circle cir(x,y,r);

	cin>>n;
	Point* p_arr = new Point[n];
	for(i=0; i<n; i++) {
		cin>>x>>y;
		p_arr[i].init(x,y);
		double dis = cir.getDis(p_arr[i]);

		if(dis<=cir.radius) {
			cout<<"inside";
		} else {
			cout<<"outside";
		}
		cout<<endl;
	}


	cin>>x>>y;	
	cir.center->init(x,y);
	cout<<"after move the centre of circle:"<<endl;
	
	for(i=0; i<n; i++) {
		double dis = cir.getDis(p_arr[i]);

		if(dis<=cir.radius) {
			cout<<"inside";
		} else {
			cout<<"outside";
		}
		cout<<endl;
	}

	delete [] p_arr;
	return 0 ;
}



