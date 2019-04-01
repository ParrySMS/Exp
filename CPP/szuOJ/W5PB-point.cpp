#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;

class Point {

		double x,y;

	public:
		Point() {
			x = 0;
			y = 0;
		}

		Point(double x,double y) {
			this->x = x;
			this->y = y;
		}

		void init(double x,double y) {
			this->x = x;
			this->y = y;
		}

		double getX() {
			return x;
		}

		double getY() {
			return y;
		}

		double setX(double x) {
			this->x = x;
		}

		double setY(double y) {
			this->y = y;
		}

		double distanse(Point p) {
			double sum = (x-p.getX())*(x-p.getX()) + (y-p.getY())*(y-p.getY());
			return sqrt(sum);
		}

		void output(Point p) {
			cout<<"Distance of Point(";
			cout<<fixed<<setprecision(2);
			cout<<x<<","<<y;
			cout<<") to Point(";
			cout<<p.getX()<<","<<p.getY();
			cout<<") is ";
			double dis = distanse(p);
			cout<<dis<<endl;
		}
};



int main() {
	const int NUM_OF_POINT = 2;
	int i,j,t;
	double x,y;
	cin>>t;
	while(t--) {
		Point *point = new Point[NUM_OF_POINT];

		for(i=0; i<NUM_OF_POINT; i++)	{
			cin>>x>>y;
			point[i].init(x,y);
		}

		point[0].output(point[1]);

		delete[] point;
		point = NULL;
	}

	return 0;
}
