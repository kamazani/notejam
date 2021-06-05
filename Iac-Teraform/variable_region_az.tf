variable "aws_region" {
    default = "eu-west-2" 
}

variable "profile" {
    default = "FredAWS"  
}

variable "ec2_ami" {
  default = "ami-0194c3e07668a7e36"
}

variable "instance_type" {
    default = "t2.micro"
}

variable "ec2_keypair" {
    default = "Fred" 
}

variable "availabilty_zones" {
    default = ["eu-west-2a","eu-west-2b"]
  
}

variable "environment" {
    default = "dev"  
}
